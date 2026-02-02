<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário para autenticação
        $this->user = User::factory()->create();

        // Autentica via Sanctum
        Sanctum::actingAs($this->user);
    }

    /** @test */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    public function test_can_create_company()
    {
        $data = ['name' => 'Empresa Test', 'email' => 'empresa@test.com'];
        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /** @test */
    public function test_can_list_companies()
    {
        Company::factory()->count(3)->create();

        $response = $this->getJson('/api/companies');

        $response->assertOk()
                 ->assertJsonStructure(['data']);
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function test_can_show_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}");
        $response->assertOk()->assertJsonFragment([
            'id' => $company->id,
            'name' => $company->name,
        ]);
    }

    /** @test */
    public function test_can_create_project()
    {
        $company = Company::factory()->create();
        $data = ['name' => 'Projeto Test', 'company_id' => $company->id];

        $response = $this->postJson('/api/projects', $data);
        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /** @test */
    public function test_can_list_projects()
    {
        Project::factory()->count(3)->create();

        $response = $this->getJson('/api/projects');

        $response->assertOk()
                 ->assertJsonStructure(['data']);
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function test_can_show_project()
    {
        $project = Project::factory()->create();

        $response = $this->getJson("/api/projects/{$project->id}");
        $response->assertOk()->assertJsonFragment([
            'id' => $project->id,
            'name' => $project->name,
        ]);
    }

    /** @test */
    public function test_can_create_ticket()
    {
        $ticket = Ticket::factory()->create();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => $ticket->title,
        ]);
    }

    /** @test */
    public function test_can_list_tickets()
    {
        Ticket::factory()->count(3)->create();

        $response = $this->getJson('/api/tickets');

        $response->assertOk()
                 ->assertJsonStructure(['data']);
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function test_can_show_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->getJson("/api/tickets/{$ticket->id}");
        $response->assertOk()->assertJsonFragment([
            'id' => $ticket->id,
            'title' => $ticket->title,
        ]);
    }

    /** @test */
    public function test_can_upload_ticket_file()
    {
        Storage::fake('local');

        $ticket = Ticket::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $file = UploadedFile::fake()->create('file.txt', 100);

        $response = $this->postJson("/api/tickets/{$ticket->id}/upload", [
            'attachment' => $file,
        ]);

        $response->assertStatus(200);

        Storage::disk('local')->assertExists("tickets/{$ticket->id}/{$file->hashName()}");
    }

    /** @test */
    public function test_can_download_ticket_file()
    {
        Storage::fake('local');

        $ticket = Ticket::factory()->create();

        $content = "Conteúdo do ticket para download";
        $ticket->detail()->create(['technical_notes' => $content]);

        // Salva o arquivo no storage
        Storage::disk('local')->put("tickets/{$ticket->id}/ticket_{$ticket->id}.txt", $content);

        $response = $this->get("/api/tickets/{$ticket->id}/download");

        $response->assertOk();

        // Validação Content-Type
        $this->assertStringStartsWith('text/plain', $response->headers->get('Content-Type'));

        // Validação Content-Disposition
        $response->assertHeader('Content-Disposition', 'attachment; filename="ticket_'.$ticket->id.'.txt"');

        // Validação conteúdo
        $this->assertEquals($content, $response->getContent());
    }

    /** @test */
    public function test_can_get_authenticated_user()
    {
        $response = $this->getJson('/api/me');

        $response->assertOk()->assertJsonFragment([
            'id' => $this->user->id,
            'email' => $this->user->email,
        ]);
    }
}
