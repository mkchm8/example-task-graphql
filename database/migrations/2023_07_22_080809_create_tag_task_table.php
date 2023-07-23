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
        Schema::create('tag_task', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->softDeletes();

            $table
                ->unsignedTinyInteger('exist')
                ->nullable()
                ->virtualAs('IF(ISNULL(deleted_at), 1, NULL)');

            $table->timestamps();
            $table->unique(['task_id', 'tag_id', 'exist']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_task');
    }
};
