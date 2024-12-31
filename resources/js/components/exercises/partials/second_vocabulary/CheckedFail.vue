<template>
    <div>
        <img
            v-if="feedbackMessage === true"
            src="../../../../../images/exercises/checked.png"
            alt=""
            width="35px"
        />
        <img
            v-else
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
    },
};
</script>
