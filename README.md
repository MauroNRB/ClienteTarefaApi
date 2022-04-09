# Cliente com Tarefas API

## Pré Requisitos
PHP 8.0
MySQL: 5.7

---

---

## Pré requisitos

Criar uma tabela do banco de dados (MySQL) do tipo utf8mb4_general_ci com o nome de "api"

Em seguida rode os seguintes comandos

```properties
composer install --ignore-platform-reqs
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force
```

---

---

## Como executar?

 - Baixe o binário do symfony: https://symfony.com/download

**Exemplo de como executa no windows**:

```properties
.\symfony.exe server:start
```

---

---

## Acessar sistema

Através da URL: http://localhost:8000/

Login: api@user.com

Senha: senha123

---

--- 

## Como parar a execução

Após finalizar a execução na linha de comando "symfony server:start" execute o seguite comando:

```properties
.\symfony.exe server:stop
```

---

--- 

## Usado a API

### Cliente

#### Listado clientes

##### URL da requisição
http://localhost:8000/api/client

##### Header
token: 6250fcac9211f

#### Metódo

GET

#### Exibido Unico Cliente

##### URL da requisição
http://localhost:8000/api/client/{id}

##### Header
token: 6250fcac9211f

#### Metódo

GET

#### Criado Cliente

##### URL da requisição
http://localhost:8000/api/client/new

##### Header
token: 6250fcac9211f

#### Metódo

POST

##### Body

Raw via JSON 

```properties
{
    "name": "Mauro Ribeiro",
    "email": "mauro@teste.com",
    "phone": "47 9-9999-9999",
    "password": "senha123",
    "genre": "M"
}
```

O campo "genre" tem os possiveis valores: "M" para homem, "F" para mulher e "O" para outros.

#### Atualizado Cliente

##### URL da requisição
http://localhost:8000/api/client/{id}/edit

##### Header
token: 6250fcac9211f

#### Metódo

PUT

##### Body

Raw via JSON 

```properties
{
    "name": "Mauro Ribeiro",
    "email": "mauro@teste.com",
    "phone": "47 9-9999-9999",
    "password": "senha123",
    "genre": "M"
}
```

O campo "genre" tem os possiveis valores: "M" para homem, "F" para mulher e "O" para outros.

---

### Tarefa

#### Listado tarefas

##### URL da requisição
http://localhost:8000/api/task

##### Header
token: 6250fcac9211f

#### Metódo

GET

#### Exibido Unico tarefa

##### URL da requisição
http://localhost:8000/api/client/{id}

##### Header
token: 6250fcac9211f

#### Metódo

GET

#### Criado tarefa

##### URL da requisição
http://localhost:8000/api/task/new

##### Header
token: 6250fcac9211f

#### Metódo

POST

##### Body

Raw via JSON

```properties
{
    "description": "Limpar a casa",
    "expirationAt": "2022-01-30",
    "conclusionAt": "2022-04-30",
    "client": 2
}
```

O campo "client" é o id do cliente

#### Atualizado tarefa

##### URL da requisição
http://localhost:8000/api/task/{id}/edit

##### Header
token: 6250fcac9211f

#### Metódo

PUT

##### Body

Raw via JSON

```properties
{
    "description": "Limpar a casa",
    "expirationAt": "2022-01-30",
    "conclusionAt": "2022-04-30",
    "client": 2
}
```

O campo "client" é o id do cliente
