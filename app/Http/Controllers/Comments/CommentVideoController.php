<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Comments\StoreVideoCommentRequest;
use App\Http\Requests\Comments\UpdateVideoCommentRequest;
use App\Services\Comments\CommentVideoService;
use App\Traits\CrudTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentVideoController extends BaseController
{
    use CrudTrait {
        store as traitStore;
        update as traitUpdate;
    }

    protected const string SERVICE = CommentVideoService::class;

    public function store(StoreVideoCommentRequest $request, $userId): JsonResource
    {
        return $this->traitStore($request, $userId);
    }

    public function update(UpdateVideoCommentRequest $request, int $userId, int $id): JsonResource
    {
        return $this->traitUpdate($request, $userId, $id);
    }
}
