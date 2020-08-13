<?php


namespace Project\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $quiz_id
 * @property string $started_at
 * @property string $finished_at
 *
 * @property UserModel $user
 * @property QuizModel $quiz
 * @property UserQuizAttemptAnswerModel[] $userAnswers
 */
class UserQuizAttemptModel extends Model
{
    protected $table = 'user_quiz_attempts';
    public $timestamps = false;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(QuizModel::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserQuizAttemptAnswerModel::class);
    }
}