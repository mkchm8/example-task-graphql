<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases;

use App\Models\Folder;
use App\Models\Task;
use App\UseCases\FolderDetailUseCase;
use Tests\Unit\UnitTestCase;

/**
 * フォルダ詳細取得ユースケースのテスト
 * @coversDefaultClass \App\Usecases\FolderDetailUseCase
 * @example php artisan test tests/Unit/UseCases/FolderDetailUseCaseTest.php
 */
final class FolderDetailUseCaseTest extends UnitTestCase
{
    private FolderDetailUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = new FolderDetailUseCase();
    }

    /**
     * @covers ::handle
     * @return void
     */
    public function testHandle(): void
    {
        // GIVEN
        /** @var Folder $folder */
        $folder = Folder::factory()->has(Task::factory())->create();

        $input = ['id' => $folder->id];

        // WHEN
        $actual = $this->useCase->handle($input);

        // THEN
        $this->assertSame($folder->id, $actual->id);
    }
}