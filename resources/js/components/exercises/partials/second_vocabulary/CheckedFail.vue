<template>
    <div>
        <img
            v-if="feedbackMessage === true"
            src="../../../../../images/exercises/checked.png"
            alt=""
            width="35px"
        />
        <img
            v-else-if="userAnswer.length == exercise.correct_vocabulary.length"
            src="../../../../../images/exercises/fail.png"
            alt=""
            width="35px"
        />
    </div>
</template>

<script>
export default {
    name: "CheckedFailSecond",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
        feedbackMessage: {
            type: Boolean,
        },
        userAnswer: {
            type: String,
        },
    },
};
</script>
