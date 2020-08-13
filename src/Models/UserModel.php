<?php


namespace Project\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 *
 * @property UserQuizAttemptModel[] $userQuizAttempts
 */
class UserModel extends Model
{

    protected $table = 'users';
    public $timestamps = false;
    protected $guarded = [];

    public function userQuizAttempts(): HasMany
    {
        return $this->hasMany(UserQuizAttemptModel::class, 'user_id', 'id');
    }
}