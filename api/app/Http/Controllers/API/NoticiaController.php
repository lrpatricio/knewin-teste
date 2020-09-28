<?php

namespace App\Http\Controllers\API;

use App\Models\Noticia;
use App\Repositories\API\NoticiaRepository;

class NoticiaController extends ApiController
{
    /**
     * NoticiaController constructor.
     */
    public function __construct()
    {
        parent::__construct(new NoticiaRepository(new Noticia()));
    }
}
