<template>
    <div class="exercice">
        <router-link
            :to="{ name: 'course', params: { id: this.$route.params.id } }"
            >Fermer (retour au parcours)</router-link
        ><br />

        Exercice n° {{ exercise.order }} - Scénario
        {{ exercise.scenario }}

        <slot></slot>

        <div class="exercice-suivant">
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
    </div>
</template>

<script>
export default {
    name: "FirstScenario",
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

<style>
.exercice {
    background-color: #fbfbfb;
    padding: 50px;
    padding-top: 50px;
    padding-bottom: 100px;

    border-radius: 7.5px;
}

.exercice-suivant {
    margin-top: 150px;
    display: flex;
    justify-content: center;
}
</style>
