'use strict'

const { Client } = require('pg');
const client = new Client({
    host: 'postgres',
    port: 5432,
    user: 'admin',
    password: 'admin',
    database: 'knewin_teste'
});
client.connect();

/**
 * Conexão ao banco de dados relacional
 */
module.exports = client;