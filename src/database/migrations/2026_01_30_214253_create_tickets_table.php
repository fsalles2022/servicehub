    <?php

    // database/migrations/2026_01_30_000003_create_tickets_table.php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('tickets');
        }
    };
