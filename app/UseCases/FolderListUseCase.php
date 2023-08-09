<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Models\Folder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class FolderListUseCase
{
    /**
     * @param array<string, mixed> $input
     * @return Collection<int, Folder>
     */
    public function handle(array $input): Collection
    {
        /** @var Collection<int, Folder> */
        return Folder::query()
            ->where('user_id', '=', Arr::get($input, 'userId'))
            ->get();
    }
}
