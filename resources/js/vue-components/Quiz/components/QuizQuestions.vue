<template>
  <div>
    <template v-if="currentQuestion">
      <h2>{{ currentQuestion.title }}</h2>

      <div class="">
        <button v-for="answer in currentQuestion.answers"
                class="btn btn-secondary"
                :class="getButtonClass(answer.id)"
                @click="selectAnswer(answer.id)"
        >
          {{ answer.title }}
        </button>
      </div>
    </template>

    <button class="btn btn-primary" :disabled="!selectedAnswerId" @click="onNextClicked()">Next</button>
  </div>
</template>

<script>
import Axios from "axios";
import {QuestionStructure} from "../quiz.structures";

export default {
  data: () => ({
    isLoading: false,
    /**
     * @type {QuestionStructure}
     */
    currentQuestion: null,
    isLastQuestion: false,
    selectedAnswerId: null,
  }),
  created() {
    this.getNextQuestion();
  },
  methods: {
    async getNextQuestion() {
      const formData = new FormData();
      formData.append('csrf', window.csrf);

      this.isLoading = true;
      await Axios.post('/quiz-rpc/get-questions', formData).then((response) => {
        this.currentQuestion = new QuestionStructure(response.data.questionData);
        this.isLastQuestion = response.data.isLastQuestion;
      }).finally(() => {
        this.isLoading = false;
      });
    },

    selectAnswer(answerId) {
      this.selectedAnswerId = answerId;
    },

    getButtonClass(answerId) {
      return {
        'btn-success': answerId === this.selectedAnswerId,
      }
    },

    onNextClicked() {
      // TODO: implement
      this.getNextQuestion();

      this.onLastQuestionSubmitted();
    },
    onLastQuestionSubmitted() {
      this.$emit('last-question-submitted')
    }
  }
}
</script>