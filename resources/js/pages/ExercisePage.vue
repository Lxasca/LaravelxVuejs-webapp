<template>
    <exercise-layout :exercise="exercise">
        <div v-if="exercise.type === 'vocabulary' && exercise.scenario == 1">
            <first-vocabulary :exercise="exercise"></first-vocabulary>
        </div>
    </exercise-layout>
</template>

<script>
import axios from "axios";
import ExerciseLayout from "../layouts/ExerciseLayout.vue";
import FirstVocabulary from "../components/exercises/FirstVocabulary.vue";

export default {
    name: "ExercisePage",
    components: { ExerciseLayout, FirstVocabulary },
    data() {
        return {
            exercise: {},
        };
    },
    mounted() {
        this.getFirstExerciceOfLevel();
    },
    // ici dès que l'user passe à l'exercice suivant (firstcnario.vue, button), pour que ça update le front lorsque le exercise_id change
    // il faut faire un watch sur exercise_id
    watch: {
        "$route.params.exercise_id": {
            immediate: true,
            handler() {
                this.getFirstExerciceOfLevel();
            },
        },
    },
    methods: {
        getFirstExerciceOfLevel() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/get-first-exercise-of-level/${exercise_id}`)
                .then((response) => {
                    this.exercise = response.data;

                    // Déchecker la radio quand on switch de page d'exercice (suite au watch)
                    const checkedRadios = document.querySelectorAll(
                        'div[class^="choice"] input[type="radio"]:checked'
                    );
                    checkedRadios.forEach((radio) => {
                        radio.checked = false;
                    });
                });
        },
    },
};
</script>
<style scoped></style>
