<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Models\Folder;
use Illuminate\Support\Arr;

class FolderDetailUseCase
{
    public function handle(array $input): Folder
    {
        /** @var Folder $folderDetail */
        $folderDetail = Folder::query()
            ->with('tasks')
            ->findOrFail(Arr::get($input, 'id'));

        return $folderDetail;
    }
}
