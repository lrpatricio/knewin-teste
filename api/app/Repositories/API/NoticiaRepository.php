<?php

namespace App\Repositories\API;

use App\Models\Noticia;

class NoticiaRepository extends ApIListRepository
{
    public function __construct(Noticia $model, $campoReferencia = 'titulo')
    {
        parent::__construct($model, $campoReferencia);
    }
}