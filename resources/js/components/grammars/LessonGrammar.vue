<template>
    <div>
        <h1>Lecon</h1>
        <h2>{{ exercise.title }}</h2>
        <p>{{ exercise.content }}</p>

        <router-link
            :to="{
                name: 'exercise',
                params: {
                    id: 1,
                    level_id: 1,
                    exercise_id: nextExerciseId,
                },
            }"
        >
            J'ai compris ! Passez aux exercises.
        </router-link>
    </div>
</template>

<script>
export default {
    name: "LessonGrammar",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    computed: {
        nextExerciseId() {
            return parseInt(this.$route.params.exercise_id) + 1;
        },
    },
};
</script>
<style scoped></style>
