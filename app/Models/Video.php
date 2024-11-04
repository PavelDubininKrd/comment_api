<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method static findOrFail(int $id)
 */
class Video extends Model
{
    public $table = 'videos';

    public function comment(): morphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->chaperone();
    }
}
