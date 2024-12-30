<template>
    <div>
        <input-choice
            name="choice"
            :value="exercise.vocabulary.word"
            v-model="selectedChoice"
            @click="
                saveForLoopLogic(
                    exercise.vocabulary.word,
                    exercise.correct_vocabulary
                )
            "
            :label="exercise.vocabulary.word"
        ></input-choice>
    </div>
</template>

<script>
import InputChoice from "./InputChoice.vue";

export default {
    name: "ContainerChoice",
    components: { InputChoice },
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    methods: {
        saveForLoopLogic() {
            this.$emit(
                "save-for-loop-logic",
                this.exercise.vocabulary.word,
                this.exercise.correct_vocabulary
            );
        },
    },
};
</script>

<style scoped lang="scss"></style>
