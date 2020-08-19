import Vue from 'vue';
import QuizMain from "./vue-components/Quiz/QuizMain";

new Vue({
    el: "#app",
    components: {
        "quiz-main": QuizMain,
    }
});