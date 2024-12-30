<template>
    <div
        v-if="
            selectedChoice == exercise.vocabulary.word_opposite_1 ||
            selectedChoice == exercise.correct_vocabulary
        "
    >
        <div>
            <p v-if="selectedChoice == exercise.correct_vocabulary">
                <img
                    src="../../../../../images/exercises/checked.png"
                    alt=""
                    width="35px"
                />
            </p>
            <p v-else>
                <img
                    src="../../../../../images/exercises/fail.png"
                    alt=""
                    width="35px"
                />
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "CheckedFail",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
        selectedChoice: {
            type: String,
        },
    },
};
</script>
