# Cliente com Tarefas API

## Pré Requisitos
PHP 8.0
MySQL: 5.7

## Banco de Dados

Rodar os seguintes comandos

```properties
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Como executar?

 - Baixe o binário do symfony: https://symfony.com/download

**Exemplo de como executa no windows**:

```properties
.\symfony.exe server:start
```

## Acessar sistema

Através da URL: http://localhost:8000/

Login: api@user.com

Senha: senha123