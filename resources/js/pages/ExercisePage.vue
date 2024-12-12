<template>
    <div v-if="exercise.type === 'vocabulary' && exercise.scenario == 1">
        <first-scenario :exercise="exercise">
            <div class="question">
                <img v-if="exercise.image" :src="exercise.image" alt="" />
            </div>
            <!-- ebauche exerciceis images / def -->

            <div class="choices">
                <div class="choice">
                    <label>
                        <input type="radio" name="choice" value="word" hidden />
                        <span>{{ exercise.vocabulary.word }}</span>
                    </label>
                </div>
                <div class="choice">
                    <label>
                        <input
                            type="radio"
                            name="choice"
                            value="word_opposite_1"
                            hidden
                        />
                        <span>{{ exercise.vocabulary.word_opposite_1 }}</span>
                    </label>
                </div>
            </div>
        </first-scenario>
    </div>
</template>

<script>
import axios from "axios";
import FirstScenario from "../layouts/scenarios/FirstScenario.vue";

export default {
    name: "ExercisePage",
    components: { FirstScenario },
    data() {
        return {
            exercise: {},
        };
    },
    mounted() {
        this.getFirstExerciceOfLevel();
    },
    methods: {
        getFirstExerciceOfLevel() {
            const exercise_id = this.$route.params.exercise_id;

            axios
                .get(`/get-first-exercise-of-level/${exercise_id}`)
                .then((response) => {
                    console.log("succès : ", response.data);
                    this.exercise = response.data;
                })
                .catch((error) => {
                    console.log("erreur :", error);
                });
        },
    },
};
</script>
<style scoped>
.choices {
    display: flex;
    justify-content: space-evenly;
}

div[class^="choice"] input[type="radio"] + span {
    padding: 35px;
    padding-left: 50px;
    padding-right: 50px;

    cursor: pointer;
    border-radius: 7.5px;

    font-size: 20px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
div[class^="choice"] input[type="radio"]:checked + span {
    background-color: #262626;
    color: #fbfbfb;
}

.question {
    display: flex;
    justify-content: center;

    margin-bottom: 100px;
}
.question img {
    width: 150px;
}
</style>
