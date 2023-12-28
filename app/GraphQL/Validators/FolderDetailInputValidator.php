<?php

declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

class FolderDetailInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', 'exists:folders,id']
        ];
    }
}