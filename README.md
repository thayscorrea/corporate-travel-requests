# corporate-travel-requests
Sistema de pedidos de viagem corporativa utilizando no back-end PHP com microserviços e no front-end Vue.js

1. Criar base de dados no seu banco de dados MySQL Local com o nome `travel_manager`
2. Rodar o Dcoker `docker-compose up -d` na raiz do projeto
3. Executar `cd api` para entrar na pasta do backend, depois executar `docker exec -it backend bash` para acessar o container da api, em seguida rodar os migrations para construir as tabelas do banco `php artisan migrate`, depois executar o seeder para preencher o banco de dados com dados ficticios `php artisan db:seed`
4. Rodar os testes unitários e de integração `php artisan test`