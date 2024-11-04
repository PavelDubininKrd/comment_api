<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static create(array $data)
 * @method static update(array $data)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 * @property string $id
 * @property int $entity_id
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends Model
{
    public const string TABLE = 'comments';

    public const array ENTITY_TYPE = [
        'video' => Video::class,
        'post' => Post::class,
    ];

    public $table = self::TABLE;

    public $fillable = [
        'text',
        'user_id',
        'commentable_id',
        'commentable_type',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
