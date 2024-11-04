<?php

namespace App\Services\Comments;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\AbstractCrudService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentPostService extends AbstractCrudService
{
    protected const string MODEL = Comment::class;
    protected const string RESOURCE = CommentResource::class;

    public function index(Request $request, $userId): JsonResource
    {
        $data = $this->getModel()::whereUserId($userId)
            ->where('commentable_type', $this->getModel()::ENTITY_TYPE['post'])
            ->paginate(config('app.pagination.per_page'));

        return $this->getResource()::collection($data);
    }

    public function create(array $data, int $userId = null, array $meta = null): void
    {
        Post::findOrFail($data['post_id']);

        $data['user_id'] = $userId;
        $data['commentable_id'] = $data['post_id'];
        $data['commentable_type'] = $this->getModel()::ENTITY_TYPE['post'];

        unset($data['post_id']);

        parent::create($data);
    }

    public function show(int $id, int $userId = null): JsonResource
    {
        $comment = Post::findOrFail($id)?->comment()->paginate(config('app.pagination.per_page'));

        return $this->getResource()::collection($comment);
    }

    public function delete(int $id, int $userId = null, array $meta = null): void
    {
        $this->getRecordQuery($id, $userId)->where('commentable_type', $this->getModel()::ENTITY_TYPE['post'])->delete();
    }
}
