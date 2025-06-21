# 🔍 UniSUAM - Desafio Técnico Full Stack

Este projeto é uma aplicação full stack desenvolvida com **Laravel** (backend), **Angular** (frontend) e **PostgreSQL**, com o objetivo de consultar e exibir informações públicas de perfis do GitHub. O ambiente é totalmente containerizado com **Docker**.

---

## 🚀 Tecnologias Utilizadas

- **Backend**: Laravel 10
- **Frontend**: Angular 20 + Tailwind CSS
- **Banco de Dados**: PostgreSQL 15
- **Containerização**: Docker + Docker Compose

---

## ⚙️ Requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Makefile (opcional, mas facilita comandos)
- Recomendado: Node 18+ e PHP 8.2+ caso rode localmente fora do container

---

## 🧩 Como executar o projeto

### 🔧 Subindo os containers com Docker Compose

```bash
docker-compose up --build
```

Isso irá:

- Buildar e subir o backend (porta `8000`)
- Buildar e subir o frontend (porta `4200`)
- Subir o banco de dados PostgreSQL (porta `5432`)

---

## 🛠️ Backend (Laravel)

O backend é responsável por:

- Consumir a API pública do GitHub
- Registrar logs de chamadas (request/response) no banco de dados
- Fornecer endpoints REST para o frontend

### Endpoints principais

- `GET /api/user/{username}` → Dados do usuário GitHub
- `GET http://localhost:8000/api/github/user/LucasMeyble/followings?page=2&per_page=2` → Lista de followings com paginação

### Comandos úteis (dentro do container)

```bash
# Acessar o container
docker-compose exec backend bash

# Rodar migrations
php artisan migrate

# Rodar testes (caso existam)
php artisan test
```

---

## 💻 Frontend (Angular)

O frontend permite:

- Busca por username do GitHub
- Exibição de dados completos do usuário
- Listagem paginada dos followings com filtro
- Responsividade (mobile-first)

### Estrutura

- `/home` → Tela inicial de busca
- `/user/:username` → Detalhes do usuário + followings

### Comando útil (dentro do container)

```bash
docker-compose exec frontend bash
npm run lint   # Caso esteja usando ESLint/Prettier
```

---

## 🧪 Testes

O projeto conta com testes automatizados no backend:

```bash
docker-compose exec backend php artisan test
```

---

## 🗃️ Banco de Dados

A aplicação usa PostgreSQL e registra logs de cada requisição feita à API do GitHub na tabela `api_logs`, contendo:

- `method`
- `endpoint`
- `payload`
- `status_code`
- `response`
- `created_at`

---

## ✅ Extras implementados

- [x] Docker e Docker Compose
- [x] Arquitetura em camadas (Controller, Service, Model)
- [x] Testes automatizados no Laravel
- [x] Responsividade com Tailwind CSS
- [x] Paginação de followings
- [x] Mensagem de fim da lista
- [x] Tratamento de erros (usuário não encontrado, limite de requisições etc.)

---

## 📦 Pipeline CI/CD (sugestão)

Para GitHub Actions (CI), criar `.github/workflows/ci.yml` com:

```yaml
name: CI

on: [push]

jobs:
  build:
    runs-on: ubuntu-latest
    services:
      postgres:
        image: postgres:15
        env:
          POSTGRES_USER: unisuam
          POSTGRES_PASSWORD: secret
          POSTGRES_DB: unisuam
        ports: ['5432:5432']
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      - name: Install dependencies
        run: cd backend && composer install
      - name: Run backend tests
        run: cd backend && php artisan test
```

---

## 📄 Licença

Este projeto foi desenvolvido para fins avaliativos e segue os termos definidos pela UniSUAM.

---

## ✍️ Autor

Desenvolvido por Lucas Meyble. Para dúvidas, entre em contato via lucasmeyble@gmail.com.
