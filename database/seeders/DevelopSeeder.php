<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Folder;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->has(
                Folder::factory(3)->has(
                    Task::factory(3)->has(
                        Tag::factory(2)
                    )
                )
            )
            ->create();
        Admin::factory()->create();
    }
}
