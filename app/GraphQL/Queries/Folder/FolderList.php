<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Folder;

use App\UseCases\FolderListUseCase;
use Illuminate\Support\Arr;

final class FolderList
{
    public function __construct(
        public readonly FolderListUseCase $folderListUseCase
    ) {
    }

    /**
     * @param null $root Always null, since this field has no parent.
     * @param array $args The field arguments passed by the client.
     * @return array
     */
    public function __invoke(mixed $root, array $args): array
    {
        /** @var array<string, mixed> $input */
        $input = Arr::get($args, 'input');
        $folderList = $this->folderListUseCase->handle($input);

        return FolderListResponse::render($folderList);
    }
}
