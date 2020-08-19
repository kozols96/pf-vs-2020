<template>
  <div>
    <h1>Thanks, {{ userName }}</h1>

    <button class="btn btn-primary" @click="onBackToStart()">Back to start</button>
  </div>
</template>

<script>
export default {
  props: {
    userName: {
      type: String,
      required: true,
    }
  },
  methods: {
    onBackToStart() {
      this.$emit('quiz-finished')
    }
  }
}
</script>