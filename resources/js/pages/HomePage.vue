<template>
    <div style="margin-left:2.5%;margin-right:2.5%">
        <section id="hero-section">

           <div id="hero-section-content">
                <h1>
                    Apprend <span style="
                    text-decoration: underline;
                    text-decoration-color: #E89156;
                    text-decoration-thickness: 10px;
                    text-underline-offset: 7.5px;
                    ">vraiment</span> l'arabe
                    <br></br>avec <span style="color: #E89156;">Kalymz</span>
                </h1>

                <p>
                    Practice smarter, not harder, with our simple and interactive tools.
                    <br></br>
                    Start speaking confidently today !
                </p>

                <section>
                    <button>Join waitlist</button>
                    <button class="btn-2">Learn more</button>
                </section>
           </div>
           <div style="
           width: 40%;
           display: flex;
           justify-content: center;
           align-items: center;
           ">
                <img
                style="border-radius: 20px;"
                width="450px"
                src="../../../public/images/hero-section.jpg"
                alt="">
           </div>

        </section>

        <!---->

        <section id="proof-clients"></section>

        <!---->

        <section id="fonctionnement"></section>

        <br></br>
        <section id="reasons">
            <div v-for="i in 2" class="card">

                <section
                style="display: flex;justify-content: left;"
                >
                    <div class="etiquette">{{ i }}</div>
                     <h5>Personalized Learning Paths</h5>
                </section>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad non voluptas id itaque delectus facere repudiandae dolor minus fuga? Quidem quaerat sapiente labore.
                </p>
            </div>
        </section>

        <section id="why-section">
            <div class="card">
            
                <section id="why-section-content">
                    <h2>
                        Notre
                        <span style="font-weight: bold;color:#E89156;">
                            méthode
                        </span>
                        expliquée par une élève
                    </h2>

                    <br></br>
            
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto vel dolores ipsa illum eveniet blanditiis eaque ? Porro illo assumenda omnis quos obcaecati mollitia ipsam dignissimos dolorem nisi. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis quo vel assumenda eaque. Vero eos illo in, pariatur ad autem, iusto voluptatum exercitationem, nisi sapiente tempore natus consectetur cupiditate laudantium.
                    </p>

                    <br></br>

                    <section style="display: flex;justify-content: space-between;">
                        <p v-for="i in 4" class="qualite">
                            
                            <img width="15px" src="https://www.svgrepo.com/show/459207/check-mark-circle-2.svg" alt="">
                            
                            Personalized lessons
                        </p>
                    </section>

                    <br></br><br></br>

                    <div style="display: flex;justify-content: center;">
                        <iframe
                            style="width: 100%; height: 600px;
                            border-radius: 20px;box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
                            "
                            src="https://www.youtube.com/embed/JBBh874X21o"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>

                </section>

            </div>
        </section>

       <!--<section id="interest">

            <h2>Est-ce que ton profil correspond à nos critères ?</h2>
            <button>Fais-le test  en 30 secondes !</button>

            <div>
                <section class="section-checkbox">
                    <input class="checkbox-input" type="checkbox" name="" id="">
                    <label class="label-checkbox-input" for="">Je m'interesse aux relations internationales et à la géopolitique.</label>
                </section>

                <section class="section-checkbox">
                    <input class="checkbox-input" type="checkbox" name="" id="">
                    <label class="label-checkbox-input" for="">Je travaille ou veux travailler dans le domaine des relations internationales</label>
                </section>

                <section class="section-checkbox">
                    <input class="checkbox-input" type="checkbox" name="" id="">
                    <label class="label-checkbox-input" for="">Je suis professeur ou étudiant</label>
                </section>

                <section class="section-checkbox">
                    <input class="checkbox-input" type="checkbox" name="" id="">
                    <label class="label-checkbox-input" for="">Je veux connaître l'actualité du Monde Arabo-musulman</label>
                </section>

                <section class="section-checkbox">
                    <input class="checkbox-input" type="checkbox" name="" id="">
                    <label class="label-checkbox-input" for="">Je veux maîtriser l'arabe littéraire</label>
                </section>
            </div>
        </section>-->
    </div>
</template>

<script>
import { Button } from "../../../src/components/ui/button";

export default {
    name: "HomePage",
    components: { Button },
};
</script>

<style scoped lang="scss">
#hero-section{
    background-color: #262626;
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);


    height: 600px;
    border-radius: 20px;

    display: flex;
    justify-content: space-between;

    padding: 2.5%;

    #hero-section-content{
        width: 60%;
        text-align: left;
        padding-left: 5%;
        padding-top: 2.5%;

        h1 {
            text-align: left;
            font-size: 70px;
            line-height: 70px;
            color: #fbfbfb;
        }

        span {
            font-weight: bold;
        }

        p {
            margin-top: 40px;
            color: #fbfbfb;
            font-size: 18px;
        }

        button {
            background-color: #fbfbfb;
            border-radius: 20px;
            padding: 7.5px 25px;
            
            margin-right: 25px;
            margin-top: 40px;
        }

        .btn-2 {
            background-color: #E89156;
            color: #fbfbfb;
        }
    }

}

#proof-clients {
    background-color: white;
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);

    height: 75px;

    border-radius: 20px;

    margin-top: -25px;
    margin-left: 3.5%;
    margin-right: 3.5%;
}

#reasons {
    padding-top: 25px;

    margin-left: 3.5%;
    margin-right: 3.5%;

    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.card {
    padding: 5%;
    border-radius: 20px;

    h5 {
        font-size: 20px;
        font-weight: normal;
    }

    .etiquette {
        width: 50px;
        height: 50px;
        border-radius: 20px;
        background-color: #E89156;

        display: flex;
        justify-content: center;
        align-items: center;
        color: #fbfbfb;

        margin-right: 15px;
    }

    p {
        margin-top: 15px;
        font-size: 18px;
        font-weight: 350;
    }
}

#interest {
    height: 600px;
    padding-top: 50px;

    h2 {
        color: #E89156;
        font-size: 40px;
        font-weight: 450;
        text-align: center;
    }

    .section-checkbox {
        margin-bottom: 10px;
        margin-left: 23.25%;

        .checkbox-input {
            width: 30px;
            height: 30px;
            transform: scale(1.25);
            accent-color: #E89156;
            vertical-align: middle;
        }
        .label-checkbox-input {
            vertical-align: middle;
            font-size: 17.5px;
        }
    }
}

#why-section {
    #why-section-content {

        margin-top: -40px;

        h2 {
            font-size: 50px;
            font-weight: 450;
            text-align: center;
        }

        .qualite {
            color: #262626;
            border-radius: 20px;

            display: flex;
            justify-content: left;
            align-items: center;

            img {
                margin-right: 10px;
            }
        }
    }
    
}
</style>
