<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Folder;

use App\Models\Folder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

final class FolderListResponse
{
    /**
     * @param EloquentCollection<int, Folder> $folderList
     * @return array
     */
    public static function render(
        EloquentCollection $folderList
    ): array {
        $result['list'] = $folderList->map(
            fn(Folder $folder) => [
                'id' => $folder->id,
                'userId' => $folder->user_id,
                'name' => $folder->name,
                'createdAt' => $folder->created_at,
                'updatedAt' => $folder->updated_at
            ]
        );

        return $result;
    }
}
