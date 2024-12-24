<template>
    <exercise-layout :exercise="exercise">
        <div v-if="exercise.type === 'vocabulary' && exercise.scenario == 1">
            <first-vocabulary
                :exercise="exercise"
                :hasFalse="hasFalse"
                :stockExercisesByScenario="stockExercisesByScenario"
                @save-for-loop-logic="verifLoopLogic($event)"
            ></first-vocabulary>
        </div>
        <div
            v-else-if="exercise.type === 'vocabulary' && exercise.scenario == 2"
        >
            <second-vocabulary :exercise="exercise"></second-vocabulary>
        </div>
        <div
            v-else-if="
                exercise.type === 'vocabulary-multiple' &&
                exercise.scenario == 2
            "
        >
            <third-multiple-vocabulary
                :exercise="exercise"
            ></third-multiple-vocabulary>
        </div>
        <div v-else-if="exercise.type === 'grammar'">
            <lesson-grammar :exercise="exercise"></lesson-grammar>
        </div>
    </exercise-layout>
</template>

<script>
import axios from "axios";
import ExerciseLayout from "../layouts/ExerciseLayout.vue";
import FirstVocabulary from "../components/exercises/FirstVocabulary.vue";
import SecondVocabulary from "../components/exercises/SecondVocabulary.vue";
import ThirdMultipleVocabulary from "../components/exercises/ThirdMultipleVocabulary.vue";
import LessonGrammar from "../components/grammars/LessonGrammar.vue";

export default {
    name: "ExercisePage",
    components: {
        ExerciseLayout,
        FirstVocabulary,
        SecondVocabulary,
        ThirdMultipleVocabulary,
        LessonGrammar,
    },
    data() {
        return {
            exercise: {},
            stockExercisesByScenario: [],
            hasFalse: null,
        };
    },
    mounted() {
        this.getFirstExerciceOfLevel();
        this.initLoopLogic();
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
        initLoopLogic() {
            // on crée le tableau (depuis le mounted) qui va stocker tous les exercices d'une même salve avec scénario commun
            this.stockExercisesByScenario = [];
        },
        verifLoopLogic(loop) {
            const id = parseInt(this.$route.params.exercise_id);

            const index = this.stockExercisesByScenario.findIndex(
                (item) => item[0] === id
            );

            if (index !== -1) {
                this.stockExercisesByScenario[index] = [id, loop];
            } else {
                this.stockExercisesByScenario.push([id, loop]);
            }

            // On check s'il y a un False
            this.hasFalse = this.stockExercisesByScenario.some((item) =>
                item.includes(false)
            );
        },
    },
};
</script>
<style scoped></style>
