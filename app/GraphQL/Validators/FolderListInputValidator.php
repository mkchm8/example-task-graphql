<?php

declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class FolderListInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'int']
        ];
    }
}
