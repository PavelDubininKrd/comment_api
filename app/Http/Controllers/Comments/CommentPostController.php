<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Comments\StorePostCommentRequest;
use App\Http\Requests\Comments\UpdatePostCommentRequest;
use App\Services\Comments\CommentPostService;
use App\Traits\CrudTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentPostController extends BaseController
{
    use CrudTrait {
        store as traitStore;
        update as traitUpdate;
    }

    protected const string SERVICE = CommentPostService::class;

    public function store(StorePostCommentRequest $request, $userId): JsonResource
    {
        return $this->traitStore($request, $userId);
    }

    public function update(UpdatePostCommentRequest $request, int $userId, int $id): JsonResource
    {
        return $this->traitUpdate($request, $userId, $id);
    }
}
