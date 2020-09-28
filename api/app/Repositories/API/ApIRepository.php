<?php

namespace App\Repositories\API;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApIRepository
{
    /**
     * @var Model
     */
    protected $object;

    /**
     * Limite de registros por página
     *
     * @var int
     */
    private $limitDefault;

    /**
     * AppRepository constructor.
     * @param Model $object
     */
    public function __construct(Model $object)
    {
        $this->object = $object;
        $this->limitDefault = 10;
    }

    /**
     * @return Model
     */
    public function getObject(): Model
    {
        return $this->object;
    }

    /**
     * @param Model $object
     * @return ApIRepository
     */
    public function setObject(Model $object): ApIRepository
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimitDefault(): int
    {
        return $this->limitDefault;
    }

    /**
     * @param int $limitDefault
     * @return ApIRepository
     */
    public function setLimitDefault(int $limitDefault): ApIRepository
    {
        $this->limitDefault = $limitDefault;
        return $this;
    }

    /**
     * Obter todos objetos
     *
     * @return Builder[]|Collection
     */
    public function index()
    {
        return $this->object->newQuery()
            ->get();
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function paginate(Request $request)
    {
        return $this->object->newQuery()
            ->paginate($request->input('limit', $this->getLimitDefault()));
    }

    /**
     * Persiste uma lista de objetos no banco
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request)
    {
        $data = $this->setDataPayload($request);
        $item = clone $this->object;
        $item->fill($data)
            ->save();

        return $item;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function update(Request $request, $id)
    {
        $item = $this->object->newQuery()->findOrFail($id);
        $item->fill($this->setDataPayload($request))
            ->save();

        return $item;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function show($id)
    {
        return $this->object->newQuery()
            ->findOrFail($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->object->destroy($id);
    }

    /**
     * Obter dados do objeto para persistência
     *
     * @param Request $request
     * @return array
     */
    protected function setDataPayload(Request $request)
    {
        return $request->all();
    }
}