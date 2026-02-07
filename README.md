🛠 ServiceHub
Sistema de Gestão de Ordens de Serviço (Laravel + Filas)

Aplicação backend desenvolvida em Laravel 12 para gestão de tickets de suporte técnico, com processamento assíncrono, eventos, filas, testes automatizados e Docker.

🎯 Objetivo

Gerenciar tickets de suporte técnico de empresas, permitindo upload opcional de arquivos (TXT/JSON), processamento em fila e enriquecimento automático do detalhe técnico.

🧩 Domínio
Entidade	Relacionamento
Company	1:N Project
Project	1:N Ticket
Ticket	1:1 TicketDetail
User	1:N Ticket
User	1:1 UserProfile
🔁 Fluxo Principal

Usuário autenticado cria um Ticket

Envia um anexo (TXT/JSON) opcional

Um Job em fila processa o arquivo

O conteúdo é salvo em TicketDetail

Um Evento é disparado

Um Listener registra/loga a notificação

🔐 Autenticação

Laravel Sanctum (Bearer Token)

POST /api/login
{
  "email": "admin@servicehub.com",
  "password": "password123"
}

📡 Endpoints
Companies

POST /api/companies

GET /api/companies

GET /api/companies/{id}

Projects

POST /api/projects

GET /api/projects

GET /api/projects/{id}

GET /api/projects?company_id={id}

Tickets

POST /api/tickets

GET /api/tickets

GET /api/tickets/{ticket}

POST /api/tickets/{ticket}/upload

Upload via multipart/form-data
attachment = arquivo.txt

⚙️ Tecnologias

Laravel 12

PHP 8.3

Sanctum

Queue (database)

Jobs, Events, Listeners

PHPUnit / Pest

Docker

🧪 Testes

Fluxo completo testado em:
ServiceHubFlowTest

php artisan test


Valida:

Empresa

Projeto

Ticket

Upload

Fila

Job

TicketDetail

📦 Fila
php artisan queue:work


Job: ProcessTicketAttachment
Event: TicketProcessed
Listener: SendTicketProcessedNotification

📂 Arquitetura
Controllers → Services → Repositories → Models
                    ↓
                 Jobs → Events → Listeners

👤 UserProfile

Relacionamento 1:1 com User:

phone

role

🚀 Como rodar o projeto
Pré-requisitos

Git

Docker

Docker Compose

Clonar
git clone https://github.com/fsalles2022/servicehub.git
cd servicehub

Subir containers
docker-compose up -d --build

Entrar no container
docker exec -it servicehub_app bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan queue:work
php artisan test

🌐 Acesso

API: http://localhost:8080

Portas padrão:

ports:
  - "8080:80"
ports:
  - "3307:3306"

📄 Exemplo de arquivo TXT
{
  "steps": [
    "Verificar servidor",
    "Reiniciar serviços",
    "Executar script de manutenção"
  ],
  "notes": "Este ticket é apenas um teste de upload.",
  "assigned_to": "Técnico Responsável",
  "priority": "alta"
}

✅ Status

Projeto 100% funcional, com backend completo, fluxo assíncrono e testes integrados.
