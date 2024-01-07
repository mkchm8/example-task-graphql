<?php

declare(strict_types=1);

namespace Tests\Feature\GraphQL\Queries\Folder;

use App\Models\Folder;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\GraphQL\GraphQLTestCase;

/**
 * フォルダ詳細取得APIのテスト
 * @coversDefaultClass \App\GraphQL\Queries\Folder\FolderDetail
 * @example php artisan test tests/Feature/GraphQL/Queries/Folder/FolderDetailTest.php
 */
final class FolderDetailTest extends GraphQLTestCase
{
    /**
     * @covers ::_invoke
     * @return void
     */
    public function test_フォルダ詳細取得API_成功(): void
    {
        // GIVEN
        /** @var User $user */
        $user = User::factory()->create();
        Sanctum::actingAs(user: $user, guard: 'user');

        /** @var Folder $folder */
        $folder = Folder::factory()->for($user)->create();

        /** @var Task $task */
        $task = Task::factory()->for($folder)->create();

        // WHEN
        $response = $this->postGraphQL(
            [
                'query' => '
                    query FolderDetail($id: ID!) {
                        folderDetail(input: {id: $id}) {
                            id
                            userId
                            name
                            createdAt
                            updatedAt
                            tasks {
                                id
                                title
                            }
                        }
                    }
                ',
                'variables' => [
                    'id' => $folder->id,
                ],
            ],
        );

        // THEN
        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'folderDetail' => [
                    'id' => (string)$folder->id,
                    'userId' => $folder->user_id,
                    'name' => $folder->name,
                    'createdAt' => $folder->created_at->format('Y-m-d H:i:s'),
                    'updatedAt' => $folder->updated_at->format('Y-m-d H:i:s'),
                    'tasks' => [
                        [
                            'id' => (string)$task->id,
                            'title' => $task->title,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
