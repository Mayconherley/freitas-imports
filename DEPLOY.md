# Deploy da Freitas Imports

Este projeto esta preparado para deploy com Docker. A forma mais simples para comecar gratis e:

- **Aplicacao Laravel:** Koyeb ou Render, usando o repositorio do GitHub.
- **Banco de dados:** Supabase, usando PostgreSQL.
- **Acesso mobile:** o cliente abre a URL pelo navegador do Android ou iOS.

## 1. Antes do deploy

No seu computador, confirme que tudo esta funcionando:

```bash
php artisan test
npm run build
git status
```

Se tiver mudancas, envie para o GitHub:

```bash
git add .
git commit -m "Prepara deploy"
git push origin main
```

## 2. Criar o banco no Supabase

1. Crie uma conta em `https://supabase.com`.
2. Crie um novo projeto.
3. Guarde a senha do banco.
4. Abra as configuracoes do projeto e copie os dados de conexao PostgreSQL.

No deploy, estes campos serao usados assim:

```env
DB_CONNECTION=pgsql
DB_HOST=host-do-supabase
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=usuario-do-supabase
DB_PASSWORD=senha-do-supabase
DB_SSLMODE=require
```

## 3. Criar a aplicacao no Koyeb ou Render

1. Entre na plataforma escolhida.
2. Crie um novo Web Service/App.
3. Conecte o GitHub.
4. Escolha o repositorio `Mayconherley/freitas-imports`.
5. Escolha deploy via **Dockerfile**.
6. Configure as variaveis de ambiente.

Variaveis principais:

```env
APP_NAME="Freitas Imports"
APP_ENV=production
APP_KEY=cole-a-chave-gerada
APP_DEBUG=false
APP_URL=https://url-final-do-deploy

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=host-do-supabase
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=usuario-do-supabase
DB_PASSWORD=senha-do-supabase
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

STORE_WHATSAPP=5511999999999
STORE_PIX_KEY=freitasimports@example.com
DEPLOY_RUN_MIGRATIONS=true
DEPLOY_RUN_SEEDERS=true
```

Para gerar a chave `APP_KEY`, rode localmente:

```bash
php artisan key:generate --show
```

Copie a chave gerada e cole no painel da hospedagem.

## 4. Primeiro deploy

No primeiro deploy, deixe:

```env
DEPLOY_RUN_MIGRATIONS=true
DEPLOY_RUN_SEEDERS=true
```

Depois que abrir o site e confirmar que o banco foi criado, troque para:

```env
DEPLOY_RUN_MIGRATIONS=false
DEPLOY_RUN_SEEDERS=false
```

Quando houver atualizacao que altera tabelas, pode voltar temporariamente `DEPLOY_RUN_MIGRATIONS` para `true`. O `DEPLOY_RUN_SEEDERS` normalmente fica `false` depois do primeiro deploy.

## 5. Login inicial

Se os dados de exemplo forem inseridos, o acesso da gestao sera:

```text
URL: /login
Email: admin@freitasimports.test
Senha: password
```

Depois do primeiro acesso, o ideal e trocar esse usuario/senha por dados reais.

## 6. Como atualizar depois

O fluxo normal sera:

```bash
git status
git add .
git commit -m "Descreva a melhoria"
git push origin main
```

Quando o push chegar no GitHub, a plataforma faz um novo deploy automatico.

Se a melhoria tiver migrations, deixe `DEPLOY_RUN_MIGRATIONS=true` durante esse deploy. Depois volte para `false`.

## 7. Pontos importantes

- O site funciona no navegador do computador, Android e iOS.
- Nao sera um aplicativo instalavel nesta etapa.
- Em planos gratuitos, o primeiro acesso pode demorar porque o servidor pode "dormir".
- Uploads locais podem sumir em hospedagens gratuitas com disco temporario. Para producao, o melhor e usar imagens por URL ou configurar um servico externo de arquivos, como Cloudinary ou S3.
- Nunca envie o arquivo `.env` para o GitHub.
