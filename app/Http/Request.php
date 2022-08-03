<?php

namespace App\Http;

class Request
{
    /**
     * Metodo HTTP da Requisição
     *
     * @var string
     */
    private string $httpMethod;

    /**
     * URI da requisição
     *
     * @var string
     */
    private string $uri;

    /**
     * Paramaetros GET da requisição
     *
     * @var array
     */
    private array $queryParams = [];

    /**
     * Parametros POST da requisição
     *
     * @var array
     */
    private array $postVars = [];

    /**
     * Cabeçalho da requisição
     *
     * @var array
     */
    private array $headers = [];

    private $router;

    /**
     * Metodo construtor
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? "";
        $this->setUri();
    }

    private function setUri(){
        $this->uri = $_SERVER['REQUEST_URI'] ?? "";

        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * Retorna o metodo http da requisição
     *
     * @return void
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }


    public function getQueryParams()
    {
        return $this->queryParams;
    }


    public function getPostVars()
    {
        return $this->postVars;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getRouter()
    {
        return $this->router;
    }
}
