<template>

  <div>

    <quiz-select
        v-if="currentStep === allSteps.STEP_QUIZ_SELECT"
        @start-clicked="onStartClicked()"
    />
    <quiz-questions
        v-else-if="currentStep === allSteps.STEP_QUIZ_QUESTIONS"
        @last-question-submitted="onLastQuestionSubmitted()"
    />
    <quiz-results
        v-else-if="currentStep === allSteps.STEP_QUIZ_RESULTS"
        :user-name="userName"
        @quiz-finished="onQuizFinished()"
    />
  </div>

</template>


<script>
import QuizSelect from "./components/QuizSelect";
import QuizQuestions from "./components/QuizQuestions";
import QuizResults from "./components/QuizResults";

const STEP_QUIZ_SELECT = 1;
const STEP_QUIZ_QUESTIONS = 2;
const STEP_QUIZ_RESULTS = 3;

const STEPS_ALL = {
  STEP_QUIZ_SELECT: STEP_QUIZ_SELECT,
  STEP_QUIZ_QUESTIONS: STEP_QUIZ_QUESTIONS,
  STEP_QUIZ_RESULTS: STEP_QUIZ_RESULTS,
};

export default {
  props: {
    userName: {
      type: String,
      required: true,
    },
    pIsQuizActive: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    QuizSelect,
    QuizQuestions,
    QuizResults,
  },
  data: () => ({
    currentStep: STEP_QUIZ_SELECT,
    isQuizActive: false,
  }),
  computed: {
    allSteps() {
      return STEPS_ALL;
    }
  },
  watch: {
    currentStep() {
      const stepExists = Object.values(STEPS_ALL).includes(this.currentStep);

      if (!stepExists) {
        this.currentStep = STEP_QUIZ_SELECT;
      }
    }
  },
  created() {
    this.isQuizActive = this.pIsQuizActive;

    if (this.isQuizActive) {
      this.currentStep = STEP_QUIZ_QUESTIONS;
    }
  },
  methods: {
    onStartClicked() {
      this.isQuizActive = true;
      this.currentStep++;
    },
    onLastQuestionSubmitted() {
      this.currentStep++;
    },
    onQuizFinished() {
      this.currentStep = STEP_QUIZ_SELECT;
    }
  }
}

</script>