# Freitas Imports

Sistema Laravel para loja virtual da Freitas Imports, com vitrine para clientes, carrinho, checkout e painel de gestao.

## Recursos principais

- Loja virtual responsiva para computador, Android e iOS pelo navegador.
- Cadastro e login de clientes.
- Carrinho e checkout com dados do pedido.
- Painel de gestao para produtos, estoque, categorias e pedidos.
- Logo e identidade visual da Freitas Imports.
- Manual de uso em Markdown e PDF.
- Preparacao para deploy com Docker.

## Rodar localmente

Configure o arquivo `.env` com o banco local e rode:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Acesse:

```text
Site: http://127.0.0.1:8000
Gestao: http://127.0.0.1:8000/login
```

Login inicial da gestao:

```text
Email: admin@freitasimports.test
Senha: password
```

## Testes

```bash
php artisan test
npm run build
```

## Deploy

O passo a passo esta em [DEPLOY.md](DEPLOY.md).

Resumo:

- Aplicacao: Koyeb ou Render usando Docker.
- Banco: Supabase com PostgreSQL.
- Atualizacoes: commit e push para a branch `main`.

## Arquivos importantes

- `MANUAL_DE_USO.md`: manual para o cliente.
- `MANUAL_DE_USO_FREITAS_IMPORTS.pdf`: manual em PDF.
- `.env.production.example`: exemplo de variaveis para hospedagem.
- `Dockerfile`: configuracao usada no deploy.
