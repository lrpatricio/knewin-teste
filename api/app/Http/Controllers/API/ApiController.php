<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\API\ApIRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Repositório onde estão as regras de negócio para a requisição atual
     *
     * @var ApIRepository
     */
    private $repository;

    /**
     * ApiController constructor.
     * @param ApIRepository $repository
     */
    public function __construct(ApIRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ApIRepository
     */
    public function getRepository(): ApIRepository
    {
        return $this->repository;
    }

    /**
     * @param ApIRepository $repository
     * @return static
     */
    public function setRepository(ApIRepository $repository): ApiController
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * Obter uma lista de objetos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $items = $this->repository->index();
        return response()->json(['items' => $items]);
    }


    /**
     * Armazenar um objeto
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try
        {
            return response()->json($this->repository->store($request));
        }
        catch(Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Obter um objeto pelo ID
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try
        {
            return response()->json($this->repository->show($id));
        }
        catch(Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualizar um objeto especificado pelo ID
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try
        {
            return response()->json($this->repository->update($request, $id));
        }
        catch(Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Deletar um objeto pelo ID
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try
        {
            $this->repository->delete($id);
            return response()->json(['message' => 'Exclusão realizada com sucesso.'], 204);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}