<template>
    <div>
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
            >
                <p v-if="feedbackMessage">Suivant</p>
                <p v-else>Réessayer</p>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NextExercise",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
        nextExercise: {
            type: Number,
            required: true,
        },
        feedbackMessage: {
            type: Boolean,
        },
    },
};
</script>
<style scoped lang="scss">
.container-next {
    background-color: #ae7cf6;
    //border: solid 2px #ae7cf6;
    //border-left: solid 20px #ae7cf6;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding-left: 25px;
    padding-right: 25px;
    padding-top: 0.5px;
    padding-bottom: 0.5px;
    border-radius: 10px;
    width: 750px;
    margin-left: 5px;
    cursor: pointer;
    text-align: center;

    p {
        font-size: 16px;
    }
}
</style>
