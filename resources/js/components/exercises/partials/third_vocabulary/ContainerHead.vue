<template>
    <section class="d-flex-center">
        <div class="container-question-multiple">
            <section class="d-flex-evenly">
                <div v-for="arrayImage in arrayImages" :key="arrayImage.id">
                    <img
                        :src="arrayImage"
                        alt="Image d'illustration"
                        width="150px"
                    />
                </div>
            </section>
        </div>
    </section>

    <div class="d-flex-center">
        <section
            class="d-flex-evenly"
            style="margin-bottom: 40px; width: 800px"
        >
            <div
                class="container-exercise-i-individuel"
                v-for="arrayTraduction in arrayTraductions"
                :key="arrayTraduction.id"
            >
                <p>{{ arrayTraduction }}</p>

                <section>
                    <img src="../../../../../images/exercises/headphones.png" />
                </section>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "ContainerHead",
    props: {
        exercise: {
            type: Object,
            required: true,
        },
        arrayImages: {
            type: Array,
            required: true,
        },
        arrayTraductions: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped lang="scss">
.container-question-multiple {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    width: 800px;
    height: 230px;
    border-radius: 10px;
    background-color: #f8da61;

    img {
        width: 150px;
        height: 150px;

        margin-top: 40px;
    }
}

.container-exercise-i-individuel {
    margin-top: -45px;

    background-color: #ae7cf6;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 10px;
    width: 150px;
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
