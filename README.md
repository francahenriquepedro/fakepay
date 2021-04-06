# FakePay

Este projeto é um exemplo de implementação de uma API back-end utilizando Laravel e Docker

## Rodando o Projeto

Primeiramente devemos ciar e preencher as informações da conexão com o banco de dados, veja o nome do container no arquivo `docker-compose.yml`

> $ cp .env.example .env

Execute o docker-compose para levantar o ambiente

> $ docker-compose -f "docker-compose.yml" up -d --build

Agora que já temos os serviços rodando, iremos configurar a key do laravel e rodar a migração do banco de dados dentro do container da aplicação:

> $ php artisan key:generate

> $ php artisan migrate --seed

Além disso deixei aqui um arquivo contendo a consulta da api no Insomnia para facilitar a navegação na API, basta impoartar o arquivo `insomnia.json`
