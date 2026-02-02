<?php

use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessTicketAttachment;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

it('executa o fluxo completo do ServiceHub', function () {

    Queue::fake();
    Storage::fake('local');

    // 1️⃣ Criar usuário
    $user = User::factory()->create([
        'email' => 'admin@servicehub.com',
        'password' => bcrypt('password123'),
    ]);

    $this->actingAs($user);

    // 2️⃣ Criar empresa
    $companyResponse = $this->postJson('/api/companies', [
        'name' => 'Acme Corp',
        'email' => 'contato@acme.com',
        'phone' => '123456789'
    ])->assertStatus(201);

    $companyId = $companyResponse->json('id');

    // 3️⃣ Criar projeto
    $projectResponse = $this->postJson('/api/projects', [
        'company_id' => $companyId,
        'name' => 'Sistema ERP',
        'description' => 'Projeto interno'
    ])->assertStatus(201);

    $projectId = $projectResponse->json('id');

    // 4️⃣ Criar ticket
    $ticketResponse = $this->postJson('/api/tickets', [
        'project_id' => $projectId,
        'title' => 'Ticket de teste',
        'description' => 'Verificar servidor',
        'status_id' => 1,
        'priority_id' => 1,
        'user_id' => $user->id
    ])->assertStatus(201);

    $ticketId = $ticketResponse->json('id');

    // 5️⃣ Upload de arquivo
    $file = UploadedFile::fake()->createWithContent(
        'tickets.txt',
        json_encode([
            'steps' => ['Verificar servidor', 'Reiniciar serviços'],
            'notes' => 'Arquivo de teste'
        ])
    );

    $this->post('/api/tickets/'.$ticketId.'/upload', [
        'attachment' => $file
    ])->assertStatus(200)
      ->assertJson(['queued' => true]);

    // 6️⃣ Verifica se Job foi enviado para fila
    Queue::assertPushed(ProcessTicketAttachment::class);

    // 7️⃣ Simula execução do Job
    $job = new ProcessTicketAttachment(
        Ticket::find($ticketId),
        'tickets/'.$file->hashName()
    );

    Storage::put(
        'tickets/'.$file->hashName(),
        file_get_contents($file->getPathname())
    );

    $job->handle();

    // 8️⃣ Confere se TicketDetail foi atualizado
    $detail = TicketDetail::where('ticket_id', $ticketId)->first();

    expect($detail)->not->toBeNull();
    expect($detail->technical_notes)->toContain('Verificar servidor');
});
