<template>
    <div class="flex h-screen w-100">
        <div class="m-auto">
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
            <div @click="speakRandom" class="text-center number-box">
                <div class="font-black text-green-500">{{ this.text }}</div>
            </div>
        </div>
    </div>
</template>
<script>
    import LaravelRoutes from '../mixins/laravel-routes';
    import RangeSlider from 'vue-range-slider';
    import 'vue-range-slider/dist/vue-range-slider.css';
    import Cookies from 'coockies';

    export default {
        props: [],
        mixins: [LaravelRoutes],
        data() {
            return {
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

            this.speakRandom();
        },
        methods: {
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
                setTimeout(() => {
                    this.text = new Intl.NumberFormat('en-US').format(text);
                }, this.hintDuration);
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
            hintDuration(newValue) {
                Cookies.set('hintDuration', newValue);
            },

            pow(newValue) {
                Cookies.set('pow', newValue);
            },
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
