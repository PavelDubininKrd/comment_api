<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method static findOrFail(int $id)
 * @method static whereUserId(int $userId)
 */
class Post extends Model
{
    public $table = 'posts';

    public function comment(): morphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->chaperone();
    }
}
