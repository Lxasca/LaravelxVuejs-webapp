<template>
    <div>
        <div :class="{ disabled: feedbackMessage }">
            <!-- 1. Affichage de l'image du mot à trouver, du mot dans la langue de l'apprenant, et l'image de l'écouteur -->
            <container-head :exercise="exercise"></container-head>

            <!-- 2. Affichage de la phrase avec l'input pour le mot à trouvé -->
            <div
                style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                "
            >
                <p class="answer">
                    <span v-for="(part, index) in sentenceParts" :key="index">
                        <span v-if="!part.isInput">{{ part.text }}</span>
                        <input
                            v-else
                            type="text"
                            v-model="userAnswer"
                            :placeholder="placeholderText"
                            :maxlength="exercise.correct_vocabulary.length"
                            @input="checkAnswer"
                        />
                    </span>
                </p>
            </div>

            <!-- Affichage du nombre de lettres saisies vs. le nombre total de lettres du mot à trouver -->
            <div
                style="
                    display: flex;
                    justify-content: right;
                    margin-top: -86.5px;
                    padding-right: 275px;
                "
            >
                <section
                    style="
                        background-color: #ae7cf6;
                        border-radius: 10px;
                        padding: 0px;
                        padding-left: 20px;
                        padding-right: 20px;
                        color: white;
                    "
                >
                    <p>
                        {{ userAnswer.length }} /
                        {{ exercise.correct_vocabulary.length }}
                    </p>
                </section>
            </div>

            <div
                style="
                    display: flex;
                    justify-content: left;
                    margin-top: -59px;
                    padding-left: 289px;
                "
            >
                <p>
                    <button
                        v-if="
                            userAnswer
                                .slice(
                                    0,
                                    Math.ceil(
                                        exercise.correct_vocabulary.length / 3
                                    )
                                )
                                .toLowerCase() !==
                            exercise.correct_vocabulary
                                .slice(
                                    0,
                                    Math.ceil(
                                        exercise.correct_vocabulary.length / 3
                                    )
                                )
                                .toLowerCase()
                        "
                        @click="provideHintFirst"
                    >
                        <img
                            src="../../../images/exercises/help1.png"
                            alt="Aide 1/3"
                            width="35px"
                        />
                    </button>
                    <button
                        v-if="
                            userAnswer.length >=
                                Math.ceil(
                                    (exercise.correct_vocabulary.length * 1) / 3
                                ) &&
                            userAnswer
                                .slice(
                                    0,
                                    Math.ceil(
                                        (exercise.correct_vocabulary.length *
                                            2) /
                                            3
                                    )
                                )
                                .toLowerCase() !==
                                exercise.correct_vocabulary
                                    .slice(
                                        0,
                                        Math.ceil(
                                            (exercise.correct_vocabulary
                                                .length *
                                                2) /
                                                3
                                        )
                                    )
                                    .toLowerCase()
                        "
                        @click="provideHintSecond"
                    >
                        <img
                            src="../../../images/exercises/help2.png"
                            alt="Aide 2/3"
                            width="35px"
                        />
                    </button>
                    <button
                        v-if="
                            userAnswer.length >=
                                Math.ceil(
                                    (exercise.correct_vocabulary.length * 2) / 3
                                ) &&
                            userAnswer
                                .slice(
                                    0,
                                    Math.ceil(
                                        (exercise.correct_vocabulary.length *
                                            3) /
                                            3
                                    )
                                )
                                .toLowerCase() !==
                                exercise.correct_vocabulary
                                    .slice(
                                        0,
                                        Math.ceil(
                                            (exercise.correct_vocabulary
                                                .length *
                                                3) /
                                                3
                                        )
                                    )
                                    .toLowerCase()
                        "
                        @click="provideHintThird"
                    >
                        <img
                            src="../../../images/exercises/help3.png"
                            alt="Aide 3/3"
                            width="35px"
                        />
                    </button>
                </p>
            </div>

            <button v-if="userAnswer.length > 0" @click="validateAnswer">
                Valider
            </button>
        </div>

        <div v-if="feedbackMessage !== null">
            <div v-if="feedbackMessage">
                <p>Réussie !</p>

                <router-link
                    :to="{
                        name: 'exercise',
                        params: {
                            id: 1,
                            level_id: 1,
                            exercise_id: nextExercise,
                        },
                    }"
                >
                    Suivant (passer)
                </router-link>
            </div>
            <p v-else>Raté ! Reessayer</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import ContainerHead from "./partials/first_vocabulary/ContainerHead.vue";

export default {
    name: "SecondVocabulary",
    components: { ContainerHead },
    props: {
        exercise: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            userAnswer: "",
            feedbackMessage: null,
            sentenceParts: [],
            currentExercise: null,
            nextExercise: null,
        };
    },
    mounted() {
        this.resetState();
        this.updateSentenceParts();
        this.determineNextExercise();
        window.addEventListener("keydown", this.handleKeydown);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.handleKeydown);
    },
    watch: {
        "$route.params.exercise_id": {
            immediate: true,
            handler() {
                this.resetState();
                this.updateSentenceParts();
                this.determineNextExercise();
                this.handleKeydown(event);
            },
        },
    },
    computed: {
        placeholderText() {
            return "_ ".repeat(this.currentExercise.correct_vocabulary.length);
        },
    },
    methods: {
        handleKeydown(event) {
            //console.log("le code : ", event.code);
            //console.log("l'id : ", this.$route.params.exercise_id);
            this.determineNextExercise();
            //console.log("le next id : ", this.nextExercise);
            /**console.log(
                "this.userAnswer.trim().toLowerCase() => ",
                this.userAnswer.trim().toLowerCase()
            );
            console.log(
                "this.currentExercise.correct_vocabulary.toLowerCase() => ",
                this.currentExercise !== null
                    ? this.currentExercise.correct_vocabulary.toLowerCase()
                    : "est null"
            );**/

            if (
                event.code === "Space" &&
                document.activeElement.tagName !== "INPUT"
            ) {
                if (this.currentExercise !== null) {
                    if (
                        this.userAnswer.trim().toLowerCase() ==
                        this.currentExercise.correct_vocabulary.toLowerCase()
                    ) {
                        console.log("LEAAAAA");
                    } else {
                        console.log("j'en ai marrrrrrrrrrrrrrrrrrrrrrr");
                    }
                }
            }
        },
        determineNextExercise() {
            let id = this.$route.params.exercise_id;

            axios.get(`/get-next-exercise-by-order/${id}`).then((response) => {
                this.nextExercise = response.data.id;
            });
        },
        checkAnswer() {
            const correctWord =
                this.currentExercise.correct_vocabulary.toLowerCase();
            if (
                this.userAnswer.toLowerCase() !==
                correctWord.slice(0, this.userAnswer.length)
            ) {
                this.userAnswer = this.userAnswer.slice(
                    0,
                    this.userAnswer.length - 1
                );
            }
        },
        validateAnswer() {
            if (
                this.userAnswer.trim().toLowerCase() ===
                this.currentExercise.correct_vocabulary.toLowerCase()
            ) {
                this.feedbackMessage = true;
            } else {
                this.feedbackMessage = false;
            }
        },
        provideHintFirst() {
            const word = this.currentExercise.correct_vocabulary;
            const hintLength = Math.ceil(word.length / 3);
            this.userAnswer = word.slice(0, hintLength);
        },
        provideHintSecond() {
            const word = this.currentExercise.correct_vocabulary;
            const hintLength = Math.ceil((word.length * 2) / 3);
            this.userAnswer = word.slice(0, hintLength);
        },
        provideHintThird() {
            const word = this.currentExercise.correct_vocabulary;
            this.userAnswer = word;
        },
        resetState() {
            this.feedbackMessage = null;
            this.userAnswer = "";
        },
        updateSentenceParts() {
            const exercise_id = parseInt(this.$route.params.exercise_id);

            axios.get(`/get-exercise/${exercise_id}`).then((response) => {
                this.currentExercise = response.data;
                const wordToReplace =
                    this.currentExercise.correct_vocabulary.toLowerCase();

                const sentence =
                    this.currentExercise.sentence.charAt(0).toUpperCase() +
                    this.currentExercise.sentence.slice(1).toLowerCase();

                const parts = sentence.split(wordToReplace);

                this.sentenceParts = parts.flatMap((part, index) => [
                    { text: part, isInput: false },
                    ...(index < parts.length - 1
                        ? [{ text: "", isInput: true }]
                        : []),
                ]);
            });
        },
    },
};
</script>

<style scoped lang="scss">
.answer {
    text-align: center;
    padding-top: 25px;

    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    width: 796px;
    height: 50px;
    border-radius: 10px;
    border: solid 2px #f8da61;

    font-size: 22px;
}

input {
    border: none;
    outline: none;
    text-align: center;
    font-size: 22px;
    background-color: transparent;
    color: #ae7cf6;
}
input::placeholder {
    color: #ae7cf6;
}

input:focus {
    box-shadow: none;
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

button {
    background-color: transparent;
    border: none;

    img {
        cursor: pointer;
    }
}
</style>
