<?php

namespace App\Repositories;

use Elasticsearch\Client;

class NoticiaRepository
{
    /** @var Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Buscar noticias cadastradas no elastic search
     *
     * @return array
     */
    public function search()
    {
        $items = $this->searchOnElasticsearch();

        return [
            'items' => $items['hits']['hits'],
            'total' => $items['hits']['total']
        ];
    }

    /**
     * Obter documento elasticSearch pelo ID
     *
     * @param $id
     * @return array
     */
    public function get($id)
    {
        return $this->elasticsearch->get([
            'index' => 'knewin_teste_noticias',
            'id' => $id
        ]);
    }

    /**
     * Buscar noticias cadastradas no elastic search
     *
     * @param bool $paginacao
     * @return array
     */
    private function searchOnElasticsearch($paginacao = true): array
    {
        $body = [];
        if($paginacao)
        {
            $body = [
                'from' => isset($_GET['page']) ? ($_GET['page'] - 1) * 20 : 0,
                'size' => 20
            ];
        }
        return $this->elasticsearch->search([
            'index' => 'knewin_teste_noticias',
            'body' => $body
        ]);
    }
}