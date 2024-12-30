<template>
    <section class="d-flex-center">
        <div class="container-question">
            <img v-if="exercise.image" :src="exercise.image" />
        </div>
    </section>

    <section class="d-flex-center" style="margin-bottom: 40px">
        <div class="container-exercise-i">
            <section>
                <p>{{ exercise.vocabulary.traduction_arabic }}</p>
            </section>

            <section>
                <img src="../../../../../images/exercises/headphones.png" />
            </section>
        </div>
    </section>
</template>

<script>
export default {
    name: "ContainerHead",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
};
</script>

<style scoped lang="scss">
.container-question {
    display: flex;
    justify-content: center;
    align-items: center;

    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    width: 800px;
    height: 230px;
    border-radius: 10px;
    background-color: #f8da61;

    img {
        width: 150px;
        height: 150px;
    }
}

.container-exercise-i {
    margin-top: -45px;

    background-color: #ae7cf6;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 10px;
    width: 350px;
    color: white;
    cursor: default;

    display: flex;
    justify-content: space-between;
    align-items: center;

    img {
        width: 35px;
        margin-top: 5.5px;
        cursor: pointer;
    }

    p {
        font-size: 25px;
    }
}
</style>
