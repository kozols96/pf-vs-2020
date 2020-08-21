<template>
  <div>
    <h1>Thanks, {{ userName }}</h1>

    <div v-if="isLoading">
      Fetching results...
    </div>
    <div v-else>
      You answered correctly to {{ correctAnswerCount }} out of {{ totalQuestionCount }} questions!
    </div>
    <button class="btn btn-primary" :disabled="isLoading" @click="onBackToStart()">Back to start</button>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  props: {
    userName: {
      type: String,
      required: true,
    },
  },
  data: () => ({
    isLoading: false,
    correctAnswerCount: null,
    totalQuestionCount: null,
  }),
  created() {
    this.getResults();
  },
  methods: {
    async getResults() {
      const formData = new FormData();
      formData.append('csrf', window.csrf);

      this.isLoading = true;

      await Axios.post('/quiz-rpc/get-results', formData).then((response) => {
        this.correctAnswerCount = response.data.correctAnswerCount;
        this.totalQuestionCount = response.data.totalQuestionCount;
      }).finally(() => {
        this.isLoading = false;
      });
    },
    onBackToStart() {
      if (this.isLoading) {
        return;
      }

      this.$emit('quiz-finished')
    },
  }
}
</script>