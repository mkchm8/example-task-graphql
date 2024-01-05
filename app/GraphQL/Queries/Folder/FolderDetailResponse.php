<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Folder;

use App\Models\Folder;
use App\Models\Task;

class FolderDetailResponse
{
    /**
     * @param Folder $folder
     * @return array
     */
    public static function render(Folder $folder): array
    {
        return [
            'id' => $folder->id,
            'userId' => $folder->user_id,
            'name' => $folder->name,
            'createdAt' => $folder->created_at,
            'updatedAt' => $folder->updated_at,
            'tasks' => $folder->tasks
                ->map(fn(Task $task) => [
                    'id' => $task->id,
                    'title' => $task->title
                ])
        ];
    }
}
