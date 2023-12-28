<?php

namespace App\GraphQL\Queries\Folder;

use App\UseCases\FolderDetailUseCase;
use Illuminate\Support\Arr;

final class FolderDetail
{
    public function __construct(
        private readonly FolderDetailUseCase $useCase
    ) {
    }

    /**
     * @param null $root
     * @param array{} $args
     * @return array
     */
    public function __invoke($root, array $args): array
    {
        /** @var array<string, mixed> $input */
        $input = Arr::get($args, 'input');
        $folderDetail = $this->useCase->handle($input);

        return FolderDetailResponse::render($folderDetail);
    }
}
