<?php

declare(strict_types=1);

namespace Tests\Feature\GraphQL\Queries\Folder;

use App\Models\Folder;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\GraphQL\GraphQLTestCase;

/**
 * フォルダ一覧取得APIのテスト
 * @coversDefaultClass \App\GraphQL\Queries\Folder\FolderList
 * @example php artisan test tests/Feature/GraphQL/Queries/Folder/FolderListTest.php
 */
final class FolderListTest extends GraphQLTestCase
{
    /**
     * @covers ::_invoke
     * @return void
     */
    public function test_フォルダ一覧取得API_成功(): void
    {
        // GIVEN
        $folderCount = 3;

        /** @var User $user */
        $user = User::factory()->has(
            Folder::factory()->has(Task::factory())->count($folderCount)
        )->create();
        Sanctum::actingAs(user: $user, guard: 'user');

        // WHEN
        $response = $this->postGraphQL(
            [
                'query' => '
                    query FolderList($userId: ID!) {
                        folderList(input: {userId: $userId}) {
                            list {
                                id
                                userId
                                name
                                createdAt
                                updatedAt
                            }
                        }
                    }
                ',
                'variables' => [
                    'userId' => $user->id,
                ],
            ],
        );

        // THEN
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'folderList' => [
                    'list' => [
                        '*' => [
                            'id',
                            'userId',
                            'name',
                            'createdAt',
                            'updatedAt',
                        ]
                    ]
                ]
            ]
        ]);

        $response->assertJsonCount($folderCount, 'data.folderList.list');
        $user->folders->each(
            fn(Folder $folder, int $index) => $response->assertJson([
                'data' => [
                    'folderList' => [
                        'list' => [
                            $index => [
                                'id' => $folder->id,
                                'userId' => $folder->user_id,
                                'name' => $folder->name,
                                'createdAt' => $folder->created_at,
                                'updatedAt' => $folder->updated_at,
                            ]
                        ]
                    ]
                ]
            ])
        );
    }
}
