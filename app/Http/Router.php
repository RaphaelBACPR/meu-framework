<?php

namespace App\Http;

use \Closure;
use \App\Http\Request;
use \Exception;
use \ReflectionFunction;

class Router
{
    private string $url = '';
    private string $prefix = '';
    private array $routes = [];
    private Request $request;

    public function __construct($url)
    {
        $this->url = $url;
        $this->request = new Request($this);

        $this->setPrefix();
    }

    private function setPrefix(): void
    {
        //PEGA AS INFORMAÇOS DA URL
        $parseUrl = parse_url($this->url);

        //SETA O PREFIXO DA URL
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute(string $method, string $route, array $params = [])
    {
        //VALIDAÇÃO DOS PARAMETROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //VARIAVEIS DA ROTA
        $params['variables'] = [];
        $patternVariable = "/{(.*?)}/";

        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //PADRAO DE VALIDAÇÃO DA URL
        $patternRoute = "/^" . str_replace("/", "\/", $route) . "$/";


        //ADICIONA A ROTA NA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }


    public function get(string $route, array $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    public function post(string $route, array $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    public function put(string $route, array $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    public function delete(string $route, array $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri(): string
    {
        //URI
        $uri = $this->request->getUri();

        //EXPLODE DA URI
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //RETORNA A URI FATIADA
        return end($xUri);
    }

    private function getRoute()
    {

        //URI
        $uri = $this->getUri();

        //METODO DA REQUISIÇÃO
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE A URI BATE COM O PADRAO
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFICA O METODO
                if (isset($methods[$httpMethod])) {
                    unset($matches[0]);

                    //VARAIVEIS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    //RETORNA OS PARAMETROS DA ROTa
                    return $methods[$httpMethod];
                }

                // //METODO NÃO ENCONTRADO
                throw new Exception('Método não permitido', 405);
            }
        }
        throw new Exception("URL não encontrada", 404);
    }

    public function run()
    {
        try {
            // //OBTEM A ROTA ATUAL
            $route = $this->getRoute();

            //VERIDICA O CONTROLADOR
            if (!isset($route['controller'])) {
                throw new Exception("A url não pode ser processada", 500);
            }

            //ARGUMENTOS DA FUNCÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? "";
            }

            //RETORNA A EXECUÇÃO DA FUNÇÃO
            return call_user_func_array($route['controller'], $args);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }
}
