PHP | MySQL | Laravel - API para receber dados de um pagamento

1 - Instalar as dependencias:

composer install

2 - (IMPORTANTE!!) Criar o arquivo .env (na raiz, pode copiar do .env.testing, e apenas alterar as informações de banco) ou configurar o arquivo /config/database.php com os dados do seu banco de dados local, para poder rodar o projeto.

3 - Execute o comando no terminal, para gerar uma chave para o arquivo .env:

php artisan key:generate

4 - Editar o arquivo .env.testing com os dados do banco de dados de teste, para poder rodar os testes automatizados.

5 - Rodar as migrations para os dois ambientes:

php artisan migrate

php artisan migrate --env=testing

6 - Rodar a aplicação:

php artisan serve

7 - Acessar:

http://localhost:8000/

Obs: Para rodar os testes, acesse o terminal: vendor/bin/phpunit

Documentação API (Enviar dados de pagamento):
- Url: http://localhost:8000/api/save
- Método: POST
- Campos para envio:
   * 'client_id' = (hash/ID do cliente que está utilizando a API, ex: '348298791817d5088a6de6')
   * 'type' = (Tipo do pagamento aceito, campos aceitos são: 'credit card' ou 'boleto')
   * 'name' => (nome do comprador)
   * 'cpf' => (CPF do comprador)
   * 'email' => (E-mail do comprador)
   * 'amount' => (Valor da compra, enviar sem pontos e vírgulas, ex: '150000')
   * 'card_user' => (Nome do dono do cartão),
   * 'card_number' => (Número do cartão, enviar no seguinte formato: '4514 1671 3283 6410')
   * 'card_expiration_date' => (Data de validade mm/aaaa, ex: '12/2018')
   * 'card_cvv' => (Senha do cartão)

Documentação API (Receber dados de pagamento):
- Url: http://localhost:8000/api/get
- Método: GET
- Campos para envio:
   * client_id = (hash/ID do cliente que está utilizando a API, ex: '348298791817d5088a6de6')
   * id = (ID do pedido feito pelo comprador)   
