<template>
    <div class="exercice">
        <router-link
            :to="{ name: 'course', params: { id: this.$route.params.id } }"
            >Fermer (retour au parcours)</router-link
        ><br />

        Exercice n° {{ exercise.order }} - Scénario
        {{ exercise.scenario }}

        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "ExerciseLayout",
    props: {
        exercise: {
            type: Object,
            required: true,
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
