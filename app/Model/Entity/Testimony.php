<?php

namespace App\Model\Entity;

use App\Utils\Database;

class Testimony
{
    public $id;
    public $nome;
    public $mensagem;
    public $data;

    public function cadastrar()
    {
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERE NO BD
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data,
        ]);

        return true;
    }

    public static function getTestimonies($where, $order, $limit = null, $fields = "*"){
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}
