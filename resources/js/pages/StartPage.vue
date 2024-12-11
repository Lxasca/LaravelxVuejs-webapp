<template>
    <div>
        <h1>Start</h1>

        <div>
            <section v-if="currentStep === 1">
                <h2>
                    Choisir la/les langues dans laquelle on peut/veut suivre le
                    cours
                </h2>

                <a @click="nextStep">Continuer</a>
            </section>

            <section v-if="currentStep === 2">
                <h2>
                    Choisir une langue enseignée dans la ou une des langue(s)
                    parlée(s)
                </h2>

                <a @click="nextStep">Continuer</a>
            </section>

            <section v-if="currentStep === 3">
                <h2>
                    Choisir une langue enseignée dans la ou une des langue(s)
                    parlée(s)
                </h2>

                <a @click="nextStep">Continuer</a>
            </section>

            <section v-if="currentStep === 4">
                <h2>Choisir le parcours qui nous interesse</h2>

                <courses-component></courses-component>

                <a @click="nextStep">Continuer</a>
            </section>

            <section v-if="currentStep === 5">
                <h2>Choisir la région du monde qui nous intéresse</h2>

                <a @click="nextStep">Continuer</a>
            </section>

            <section v-if="currentStep === 6">
                <h2>C'est parti !</h2>

                <router-link :to="{ name: 'course', params: { id: 1 } }">
                    Commencer à apprendre cette langue de 0</router-link
                >
                <br />
                <a> Faire un test de niveau</a>
            </section>
        </div>
    </div>
</template>

<script>
import CoursesComponent from "../components/CoursesComponent.vue";

export default {
    name: "StartPage",
    components: { CoursesComponent },
    data() {
        return {
            currentStep: 1,
        };
    },
    methods: {
        nextStep() {
            if (this.currentStep < 6) {
                this.currentStep++;
            }
        },
    },
};
</script>

<style scoped></style>
