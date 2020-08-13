<?php


namespace Project\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $attempt_id
 * @property int $question_id
 * @property int $answer_id
 *
 * @property UserQuizAttemptModel $attempt
 * @property QuestionModel $question
 * @property AnswerModel $answer
 */
class UserQuizAttemptAnswerModel extends Model
{

    protected $table = 'user_quiz_attempt_answers';
    public $timestamps = false;
    protected $guarded = [];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(UserQuizAttemptModel::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionModel::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(AnswerModel::class);
    }
}