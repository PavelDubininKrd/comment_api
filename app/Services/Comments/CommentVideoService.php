<?php

namespace App\Services\Comments;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Video;
use App\Services\AbstractCrudService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentVideoService extends AbstractCrudService
{
    protected const string MODEL = Comment::class;
    protected const string RESOURCE = CommentResource::class;

    public function index(Request $request, $userId): JsonResource
    {
        $data = $this->getModel()::whereUserId($userId)
            ->where('commentable_type', $this->getModel()::ENTITY_TYPE['video'])
            ->paginate(config('app.pagination.per_page'));

        return $this->getResource()::collection($data);
    }

    public function create(array $data, int $userId = null, array $meta = null): void
    {
        Video::findOrFail($data['video_id']);

        $data['user_id'] = $userId;
        $data['commentable_id'] = $data['video_id'];
        $data['commentable_type'] = $this->getModel()::ENTITY_TYPE['video'];

        unset($data['video_id']);

        parent::create($data);
    }

    public function show(int $id, int $userId = null): JsonResource
    {
        $comment = Video::findOrFail($id)?->comment()->paginate(config('app.pagination.per_page'));

        return $this->getResource()::collection($comment);
    }

    public function delete(int $id, int $userId = null, array $meta = null): void
    {
        $this->getRecordQuery($id, $userId)->where('commentable_type', $this->getModel()::ENTITY_TYPE['video'])->delete();
    }
}
