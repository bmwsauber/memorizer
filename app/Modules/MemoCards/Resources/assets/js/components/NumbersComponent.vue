<template>
    <div>
        <div class="work-content">
            <div>
                <input class="value" v-model="calculatedMaxHuman">
                <div class="text-center">
                    <range-slider class="slider" min="1" max="10" step="1" v-model="pow"></range-slider>
                </div>
            </div>
            <div>
                <input class="value" type="number" v-model="hintDuration">
                <div class="text-center">
                    <range-slider class="slider" min="0" max="10000" step="500" v-model="hintDuration"></range-slider>
                </div>
            </div>
            <div v-if="openAnswer" class="answer w-100 text-9xl">
                <div>
                    <h2><span>{{ text }}</span></h2>
                </div>
            </div>
            <div v-else class="question w-100 text-9xl">
                <h1>&nbsp;</h1>
            </div>
            <div class="buttons w-100 mt-3">
                <div v-if="openAnswer" class="answer-buttons">
                    <button type="button" class="btn btn-info" @click="sendAnswerData(1, true)">Right :))</button>
                    <button type="button" class="btn btn-danger" @click="sendAnswerData(1, false)">Wrong :(</button>
                </div>
                <div v-else>
                    <button type="button" class="btn btn-info" @click="showAnswer">Show Answer</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import LaravelRoutes from '../mixins/laravel-routes';
    import RangeSlider from 'vue-range-slider';
    import 'vue-range-slider/dist/vue-range-slider.css';
    import Cookies from "coockies";

    export default {
        props: [],
        mixins: [LaravelRoutes],
        data() {
            return {
                currentQuestion: "&nbsp;",
                currentAnswer: '',
                openAnswer: false,
                showAdditionalButtons: false,

                synth: window.speechSynthesis,
                message: new window.SpeechSynthesisUtterance(),
                text: "",
                hintDuration: Cookies.get('hintDuration', '3000'),
                pow: Cookies.get('pow', 2),

            }
        },
        components: {
            RangeSlider,
            Cookies,
        },
        mounted() {
            this.message.voiceURI = 'native';
            this.message.volume = 1; // 0 to 1
            this.message.rate = 1; // 0.1 to 10
            this.message.pitch = 2; //0 to 2
            this.message.lang = 'en-US';

            this.showQuestion();
        },
        methods: {
            showQuestion() {
                this.openAnswer = false;
                window.addEventListener('keyup', this._respondQuestion);
                this.speakRandom();
            },

            /**
             * Show hidden div
             */
            showAnswer(event) {
                this.openAnswer = true;
                window.addEventListener('keyup', this._respondAnswer);
            },

            /**
             * Mark this card as new level and show new card
             *
             * @param level
             * @param isCorrect
             */
            sendAnswerData(level, isCorrect) {
                this.showQuestion();
            },

            /**
             * Play Sound
             *
             * @private
             */
            _playSound() {
                let audio = new Audio("/ding-sound-effect.mp3");
                audio.volume = 0.5;
                audio.play();
            },

            /**
             * Keyboard Handling
             *
             * @param event
             * @private
             */
            _respondAnswer(event) {
                switch (event.code) {
                    case 'Escape':
                        this.sendAnswerData(1, false);
                        break;
                    case 'Space':
                        this.sendAnswerData(1, true);
                        break;
                    default :
                        return;
                }

                window.removeEventListener("keyup", this._respondAnswer);
            },

            /**
             * Keyboard Handling
             *
             * @param event
             * @private
             */
            _respondQuestion(event) {
                switch (event.code) {
                    case 'Space':
                        this.showAnswer();
                        break;
                    case 'Backspace':
                        this.cardIndex--;
                        this.showAnswer();
                        break;
                    default :
                        return;
                }

                window.removeEventListener("keyup", this._respondQuestion);
            },

            speakRandom() {
                this.text = this._generateBetween(this.calculatedMax, 0);
                this._speak(this.text);
            },

            _generateBetween(max, min) {
                return Math.floor(
                    Math.random() * (max - min) + min
                )
            },

            _speak(text) {
                this.text = "";
                this.message.text = text;
                this.synth.speak(this.message);
                this.text = new Intl.NumberFormat('en-US').format(text);
            }
        },
        computed: {

            calculatedMax() {

                return Math.pow(10, this.pow);
            },

            calculatedMaxHuman() {
                return new Intl.NumberFormat('en-US').format(Math.pow(10, this.pow));
            }
        },
        watch: {


        }
    }
</script>
<style>
    .slider {
        /* overwrite slider styles */
        width: 100%;
    }

    .number-box {
        min-height: 300px;
        min-width: 400px;
        font-size: 140px;
    }
</style>
