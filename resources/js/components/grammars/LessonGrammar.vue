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
                    exercise_id: nextExercise,
                },
            }"
        >
            J'ai compris ! Passez aux exercises.
        </router-link>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "LessonGrammar",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            nextExercise: null,
        };
    },
    mounted() {
        this.determineNextExercise();
    },
    watch: {
        "$route.params.exercise_id": {
            immediate: true,
            handler() {
                this.determineNextExercise();
            },
        },
    },
    methods: {
        determineNextExercise() {
            let id = this.$route.params.exercise_id;

            axios.get(`/get-next-exercise-by-order/${id}`).then((response) => {
                this.nextExercise = response.data.id;
            });
        },
    },
};
</script>
<style scoped></style>
