# API
#### Comandos para configuração do projeto da api, encontrado dentro da pasta api
    composer update
    php artisan migrate
    php artisan ui bootstrap
    npm install
_As configurações para o .env estão atualizadas dentro do .env.example_
# Docker
#### Inicialização dos containers no docker
    docker-compose up -d

# Indexação
#### Para executar a indexação execute o comando abaixo:
    docker-compose up -d --build indexador

# Documentação API
#### Criado uma documentação para API no Postman, conteúdo para importação adicionado a pasta POSTMAN.