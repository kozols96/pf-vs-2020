<?php


namespace Project\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $question_id
 * @property string $title
 * @property bool $is_correct
 *
 * @property QuestionModel $question
 * @property UserQuizAttemptAnswerModel[] $userAttemptAnswers
 */
class AnswerModel extends Model
{

    protected $table = 'answers';
    public $timestamps = false;
    protected $guarded = [];

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionModel::class);
    }

    public function userAttemptAnswers(): HasMany
    {
        return $this->hasMany(UserQuizAttemptAnswerModel::class, 'answer_id', 'id');
    }
}