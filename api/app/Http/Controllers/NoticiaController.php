<?php

namespace App\Http\Controllers;

use App\Helpers\Arrays;
use App\Repositories\NoticiaRepository;
use Elasticsearch\Client;

class NoticiaController extends Controller
{
    /**
     * @var NoticiaRepository
     */
    private $repository;

    /**
     * NoticiaController constructor.
     * @param NoticiaRepository $repository
     */
    public function __construct(NoticiaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->repository->search();
        $items = Arrays::paginate($data['items'], $data['total'], 20, null, ['path' => route('noticia')]);
        return view('noticia.lista', compact('items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        return view('noticia.detalhes', compact('item'));
    }
}
