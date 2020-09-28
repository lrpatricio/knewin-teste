<?php

namespace App\Repositories\API;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApIListRepository extends ApIRepository
{
    /**
     * Item atual percorrido no metodo store
     *
     * @var mixed
     */
    private $itemAtual;

    /**
     * Campo de referência para informar sucessos e falhas
     *
     * @var string
     */
    private $campoReferencia;

    /**
     * ApIListRepository constructor.
     * @param Model $model
     * @param $campoReferencia
     */
    public function __construct(Model $model, $campoReferencia)
    {
        parent::__construct($model);
        $this->campoReferencia = $campoReferencia;
    }

    /**
     * @return mixed
     */
    public function getItemAtual()
    {
        return $this->itemAtual;
    }

    /**
     * @param mixed $itemAtual
     * @return ApIListRepository
     */
    public function setItemAtual($itemAtual)
    {
        $this->itemAtual = $itemAtual;
        return $this;
    }

    /**
     * @return string
     */
    public function getCampoReferencia(): string
    {
        return $this->campoReferencia;
    }

    /**
     * @param string $campoReferencia
     * @return ApIListRepository
     */
    public function setCampoReferencia(string $campoReferencia): ApIListRepository
    {
        $this->campoReferencia = $campoReferencia;
        return $this;
    }

    /**
     * Armazenar uma lista de objetos
     * @param Request $request
     * @return array|Model
     */
    public function store(Request $request)
    {
        $response = [
            'success' => [],
            'fails' => []
        ];

        /**
         * Percorre todos os objetos enviados na requisição para a API
         */
        foreach($request->all() as $item)
        {
            try
            {
                /**
                 * Armazena o item Atual para utilização no setDataPayload
                 */
                $this->setItemAtual($item);
                /**
                 * Persiste o objeto atual no banco de dados relacional
                 */
                parent::store($request);

                $response['success'][] = $item[$this->campoReferencia];
            }
            catch(\Exception $e)
            {
                $response['fails'][] = [
                    'titulo' => $item[$this->campoReferencia],
                    'error' => $e->getMessage()
                ];
            }
        }

        return $response;
    }

    /**
     * Obter dados do objeto para persistência
     *
     * @param Request $request
     * @return array
     */
    protected function setDataPayload(Request $request)
    {
        return $this->getItemAtual();
    }
}