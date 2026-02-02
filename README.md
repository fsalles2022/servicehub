🛠 ServiceHub — Sistema de Gestão de Ordens de Serviço

| Requisitos:               | Status |
| ----------------------- | ------ |
| Company → Projects      | ✅      |
| Project → Tickets       | ✅      |
| Ticket → TicketDetail   | ✅      |
| User → Tickets          | ✅      |
| User → UserProfile      | ✅      |
| Upload + Queue Job      | ✅      |
| Events + Listeners      | ✅      |
| Enriquecimento de dados | ✅      |
| Notificação simulada    | ✅      |
| Autenticação            | ✅      |
| Docker                  | ✅      |
-------------------------------------


Aplicação desenvolvida em Laravel 12 para gestão de ordens de serviço, seguindo arquitetura em camadas, com processamento assíncrono, eventos, relacionamentos entre entidades e testes automatizados.

🎯 Objetivo

Gerenciar Tickets de suporte técnico de empresas, com upload opcional de anexos (JSON/TXT), processamento em fila e enriquecimento automático do detalhe técnico.

🧩 Domínio

Company 1:N Project

Project 1:N Ticket

Ticket 1:1 TicketDetail

User 1:1 UserProfile

User interage com Tickets

🔁 Fluxo Principal

Usuário autenticado cria um Ticket

Envia um anexo (TXT/JSON) opcional

Um Job em fila processa o arquivo

O conteúdo é salvo no TicketDetail

Um Evento é disparado

Um Listener registra/loga a notificação

🔐 Autenticação

Laravel Sanctum (Token Bearer)

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

Upload via multipart/form-data:

Key: attachment
Value: arquivo.txt

⚙️ Tecnologias

Laravel 12

PHP 8.3

Sanctum (Auth)

Queue (database)

Jobs + Events + Listeners

Pest/PHPUnit

Docker

🧪 Testes

Fluxo completo testado via ServiceHubFlowTest:

php artisan test


Testa:

Criação de empresa

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

📂 Estrutura
Controllers → Services → Repositories → Models
                       ↓
                     Jobs → Events → Listeners

👤 UserProfile

Relacionamento 1:1 com User:

phone

role

✅ Status

Projeto 100% funcional, com backend completo, fluxo assíncrono e testes integrados.

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan queue:work
php artisan test
----------------------------------------------------------------------------------

🚀 Como Rodar o Projeto Localmente 
Siga os passos abaixo para clonar o repositório e subir o ambiente usando Docker.
1. Pré-requisitos
Certifique-se de ter instalado em sua máquina: 

    Git
    Docker
    Docker Compose

2. Clonar o Repositório 
Abra o terminal e execute o comando abaixo para baixar o código:
bash

git clone https://github.com/fsalles2022/servicehub.git
cd servicehub

3. Configurar Variáveis de Ambiente
Copiar .env.example para .env
cp .env.example .env
(Edite o arquivo .env com as suas credenciais, se necessário).

5. Subir os Containers
Com o Docker aberto, execute o comando para baixar as imagens e iniciar os serviços:
bash

docker-compose up -d --build

6. Entrar no container
docker exec -it servicehub_app bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan queue:work
php artisan test

5. Acessar a Aplicação
Após o build finalizar, a aplicação estará disponível em:

API: http://localhost:8080

OBS: Ajustar docker-compose com variaveis de portas conforme seu ambiente no arquivo baixado está assim:

         ports:
      - "8080:80"
         ports:
      - "3307:3306"


Exemplo de modelo para arquivo .txt pra o TICKET

[tickets.txt](https://github.com/user-attachments/files/25012236/tickets.txt){
  "steps": [
    "Verificar servidor",
    "Reiniciar serviços",
    "Executar script de manutenção"
  ],
  "notes": "Este ticket é apenas um teste de upload.",
  "assigned_to": "Técnico Responsável",
  "priority": "alta"
}


      

