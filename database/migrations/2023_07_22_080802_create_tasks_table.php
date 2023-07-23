<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('folder_id')->unsigned();
            $table->string('title');
            $table->dateTime('due_by');
            $table->enum('task_status', ['todo', 'doing', 'done']);
            $table->softDeletes();

            $table
                ->unsignedTinyInteger('exist')
                ->nullable()
                ->virtualAs('IF(ISNULL(deleted_at), 1, NULL)');

            $table->timestamps();
            $table->unique(['user_id', 'folder_id', 'title', 'exist']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
