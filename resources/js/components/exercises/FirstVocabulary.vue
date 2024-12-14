<template>
    <div class="question">
        <img v-if="exercise.image" :src="exercise.image" alt="" />
    </div>

    <div :class="{ disabled: selectedChoice !== null }" class="choices">
        <div class="choice">
            <label>
                <input
                    type="radio"
                    name="choice"
                    :value="exercise.vocabulary.word"
                    v-model="selectedChoice"
                    hidden
                />
                <span>{{ exercise.vocabulary.word }}</span>
            </label>
        </div>
        <div class="choice">
            <label>
                <input
                    type="radio"
                    name="choice"
                    :value="exercise.vocabulary.word_opposite_1"
                    v-model="selectedChoice"
                    hidden
                />
                <span>{{ exercise.vocabulary.word_opposite_1 }}</span>
            </label>
        </div>
    </div>

    <div class="exercice-suivant" v-if="selectedChoice">
        <div v-if="selectedChoice == exercise.correct_vocabulary">
            <h5>Réussie !</h5>
        </div>
        <div v-else>
            <h5>
                Raté ! Voici la solution correcte :
                {{ exercise.correct_vocabulary }}
            </h5>
        </div>

        <br /><br />

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
            Suivant
        </router-link>
    </div>
</template>

<script>
export default {
    name: "FirstVocabulary",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedChoice: null,
            isDisabled: false,
        };
    },
    computed: {
        nextExerciseId() {
            this.selectedChoice = null;
            return parseInt(this.$route.params.exercise_id) + 1;
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

.disabled {
    pointer-events: none;
}
</style>
