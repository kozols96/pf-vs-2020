<?php


namespace Project\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
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