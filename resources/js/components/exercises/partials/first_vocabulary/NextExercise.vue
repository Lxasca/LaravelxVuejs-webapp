<template>
    <div
        v-if="
            selectedChoice == exercise.vocabulary.word_opposite_1 ||
            selectedChoice == exercise.correct_vocabulary
        "
    >
        <div class="container-next">
            <router-link
                :to="{
                    name: 'exercise',
                    params: {
                        id: 1,
                        level_id: 1,
                        exercise_id: nextExercise,
                    },
                }"
                style="text-decoration: none; color: white"
                @click="generateRandomNumber"
            >
                <p
                    v-if="
                        stockExercisesByScenario.filter(
                            (item) => item[1] === false
                        ).length === 1 &&
                        stockExercisesByScenario.some(
                            (item) =>
                                item[0] === exercise.id && item[1] === false
                        ) &&
                        countSameScenario
                    "
                >
                    Réessayer !
                </p>
                <p v-else>Suivant</p>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NextExercise",
    props: {
        selectedChoice: {
            type: [String, Number],
            required: true,
        },
        exercise: {
            type: Object,
            required: true,
        },
        stockExercisesByScenario: {
            type: Array,
            required: true,
        },
        nextExercise: {
            type: Number,
            required: true,
        },
        countSameScenario: {
            type: Boolean,
            required: true,
        },
    },
    methods: {
        generateRandomNumber() {
            this.$emit("generate-random-number");
        },
    },
};
</script>
