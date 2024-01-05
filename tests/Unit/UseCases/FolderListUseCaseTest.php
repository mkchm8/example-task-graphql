<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases;

use App\Models\Folder;
use App\Models\Task;
use App\Models\User;
use App\UseCases\FolderListUseCase;
use Tests\Unit\UnitTestCase;

/**
 * フォルダ一覧取得ユースケースのテスト
 * @coversDefaultClass \App\Usecases\FolderListUseCase
 * @example php artisan test tests/Unit/UseCases/FolderListUseCaseTest.php
 */
final class FolderListUseCaseTest extends UnitTestCase
{
    private FolderListUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = new FolderListUseCase();
    }

    /**
     * @covers ::handle
     * @return void
     */
    public function testHandle(): void
    {
        // GIVEN
        /** @var User $user */
        $user = User::factory()->has(
            Folder::factory()->has(Task::factory())
        )->create();

        $input = ['userId' => $user->id];

        // WHEN
        $actual = $this->useCase->handle($input);

        // THEN
        $this->assertSame($user->id, $actual->first()?->user_id);
    }
}
