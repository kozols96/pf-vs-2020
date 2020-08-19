<template>
  <div>
    <h1>QUESTIONS!</h1>

    <button class="btn btn-primary" @click="onNextClicked()">Next</button>
  </div>
</template>

<script>
export default {
  methods: {
    onNextClicked() {
      // TODO: implement

      this.onLastQuestionSubmitted();
    },
    onLastQuestionSubmitted() {
      this.$emit('last-question-submitted')
    }
  }
}
</script>