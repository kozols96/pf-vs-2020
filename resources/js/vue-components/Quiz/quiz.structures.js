class QuizStructure {
    constructor(params) {
        /** @type {Number} */
        this.id = params.id !== undefined ? params.id : null;

        /** @type {String} */
        this.name = params.name !== undefined ? params.name : null;

        /** @type {Number} */
        this.questionCount = params.questionCount !== undefined ? params.questionCount : null;

        // isCompleted
    }
}

class QuestionStructure {
    constructor(params) {
        /** @type {Number} */
        this.id = params.id !== undefined ? params.id : null;

        /** @type {Number} */
        this.quizId = params.quizId !== undefined ? params.quizId : null;

        /** @type {String} */
        this.title = params.title !== undefined ? params.title : null;

        /** @type {Array.<AnswerStructure>} */
        this.answers = [];

        if (params.answers !== undefined) {
            const answerData = params.answers;

            this.answers = answerData.map((answerDatum) => new AnswerStructure(answerDatum));

            delete params.answers;
        }
    }
}

class AnswerStructure {
    constructor(params) {
        /** @type {Number} */
        this.id = params.id !== undefined ? params.id : null;

        /** @type {Number} */
        this.questionId = params.questionId !== undefined ? params.questionId : null;

        /** @type {String} */
        this.title = params.title !== undefined ? params.title : null;
    }
}

export {QuizStructure, QuestionStructure, AnswerStructure};