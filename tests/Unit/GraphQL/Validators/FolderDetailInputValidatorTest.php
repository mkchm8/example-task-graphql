<?php

declare(strict_types=1);

namespace Tests\Unit\GraphQL\Validators;

use App\GraphQL\Validators\FolderDetailInputValidator;
use App\Models\Folder;
use Illuminate\Support\Facades\Validator;
use Generator;
use Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass  \App\GraphQL\Validators\FolderDetailInputValidator
 * @example php artisan test tests/Unit/GraphQL/Validators/FolderDetailInputValidatorTest.php
 */
final class FolderDetailInputValidatorTest extends UnitTestCase
{
    private FolderDetailInputValidator $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app->make('App\GraphQL\Validators\FolderDetailInputValidator');
    }

    /**
     * @dataProvider dataProvider
     * @covers ::rules
     * @param array<string, mixed> $input
     * @param bool $isValid
     * @param array $messages
     * @return void
     */
    public function testValidation(array $input, bool $isValid, array $messages): void
    {
        // GIVEN
        // 期待結果が成功の場合、必須となるデータをあらかじめ作成する
        if ($isValid) {
            Folder::factory()->create(['id' => 1]);
        }

        // WHEN
        $actual = Validator::make($input, $this->validator->rules());

        // THEN
        $this->assertSame($isValid, $actual->passes());

        if ($isValid) {
            $this->assertSame($messages, $actual->messages()->toArray());
        } else {
            $actualMessages = $actual->messages()->toArray();
            foreach ($actualMessages as $key => $actualMessage) {
                $this->assertSame($messages[$key], $actualMessage);
            }
        }
    }

    /**
     * @dataProvider dataProvider
     * @return Generator
     */
    public static function dataProvider(): Generator
    {
        $validInput = ['id' => 1];

        yield '正常系' => [
            'input' => $validInput,
            'isValid' => true,
            'messages' => [],
        ];

        yield 'idが未指定の場合はエラー' => [
            'input' => array_replace($validInput, ['id' => null]),
            'isValid' => false,
            'messages' => ['id' => ['The id field is required.']],
        ];

        yield 'idがintでない場合はエラー' => [
            'input' => array_replace($validInput, ['id' => 'a']),
            'isValid' => false,
            'messages' => ['id' => ['The id field must be an integer.']],
        ];

        yield 'idが存在しない場合はエラー' => [
            'input' => array_replace($validInput, ['id' => 999]),
            'isValid' => false,
            'messages' => ['id' => ['The selected id is invalid.']],
        ];
    }
}
