'use strict'

const { Client } = require('@elastic/elasticsearch')
const conn = require('./config/database')
const client = new Client({ node: 'http://elasticsearch:9200' });
const indexElasticSearch = 'knewin_teste_noticias';

const run = () => {
    return new Promise((resolve, reject) => {
        /**
         * Buscar 200 notícias no banco de dados relacional
         * Foi utilizado 200 para não haver uma sobrecarga na aplicação, assim se tratando 
         * de um serviço que seria automatizado a cada chamada realizaria a importação de 200 notícias
         */
        conn.query('SELECT * FROM noticias WHERE sincronizado = 0 LIMIT 200 OFFSET 0', async (err, res) => {
            if(err)
            {
                // Caso de erro na consulta rejeita a Promise
                reject();
            }

            try
            {
                /**
                 * Percorre as notícias obtidas no banco de dados relacional 
                 * para persistencia no elasticsearch
                 */
                await res.rows.forEach(async value => {
                    try
                    {
                        /**
                         * Persiste a noticia no elasticsearch e atualiza o status no banco de dados
                         * relacional para sincronizado.
                         */
                        await client.index({
                            index: indexElasticSearch,
                            id: value.id,
                            body: value
                        }, conn.query('UPDATE noticias SET sincronizado = 1 WHERE id = '+value.id));
                    }
                    catch(e)
                    {

                    }
                });

                /**
                 * Atualiza os índices do elastic search
                 */
                await client.indices.refresh({ index: indexElasticSearch });
                
                // Caso de sucesso resolve a Promise
                resolve();
            }
            catch(e)
            {
                // Caso de erro na consulta rejeita a Promise
                reject(e);
            }
        });
    })
}
run().finally(() => {
    /**
     * Finaliza a conexão com banco de dados relacionado
     */
    conn.end(); 
});