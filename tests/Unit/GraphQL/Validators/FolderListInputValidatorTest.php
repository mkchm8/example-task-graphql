<?php

declare(strict_types=1);

namespace Tests\Unit\GraphQL\Validators;

use App\GraphQL\Validators\FolderListInputValidator;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Generator;
use Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass  \App\GraphQL\Validators\FolderListInputValidator
 * @example php artisan test tests/Unit/GraphQL/Validators/FolderListInputValidatorTest.php
 */
final class FolderListInputValidatorTest extends UnitTestCase
{
    private FolderListInputValidator $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app->make('App\GraphQL\Validators\FolderListInputValidator');
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
            User::factory()->create(['id' => 1]);
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
        $validInput = ['userId' => 1];

        yield '正常系' => [
            'input' => $validInput,
            'isValid' => true,
            'messages' => [],
        ];

        yield 'userIdが未指定の場合はエラー' => [
            'input' => array_replace($validInput, ['userId' => null]),
            'isValid' => false,
            'messages' => ['userId' => ['The user id field is required.']],
        ];

        yield 'userIdがintでない場合はエラー' => [
            'input' => array_replace($validInput, ['userId' => 'a']),
            'isValid' => false,
            'messages' => ['userId' => ['The user id field must be an integer.']],
        ];

        yield 'userIdが存在しない場合はエラー' => [
            'input' => array_replace($validInput, ['userId' => 999]),
            'isValid' => false,
            'messages' => ['userId' => ['The selected user id is invalid.']],
        ];
    }
}
