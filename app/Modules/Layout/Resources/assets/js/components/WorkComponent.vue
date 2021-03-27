<template>
    <div class="flex flex-col justify-between absolute h-full w-full">
        <div class="progress-bar relative bg-gray-100 w-full h-7">
            <div class="absolute top-0-left-0 bg-teal-100 text-center h-7" :style="{ width : progressWidth + '%' }">
                <span class="text-white text-lg">{{ ( cardIndex + 1 ) }} / {{ totalCards }}</span>
            </div>
        </div>
        <div class="card-content text-center">
            <div class="color-bar flex justify-center">
                <knowledge-meter
                    :knowledgeMeterValue="knowledgeMeterValue"
                    :envUnique="envUnique"
                >
                </knowledge-meter>
            </div>
            <div class="question text-5xl mt-6">
                <span v-if="(!$store.state.listeningMode || ($store.state.listeningMode && openAnswer))">{{ currentQuestion }}</span>
                <span v-else>&nbsp;</span>
                <span v-if="currentCard.category" class="text-4xl"> <i
                    :class="currentCard.category.icon_path"></i></span>
            </div>
            <div class="speaker text-4xl p-3 pt-4">
                <i @click="speech" v-if="(currentQuestionLang == 'eng' || $store.state.listeningMode || openAnswer)"
                   class="fas fa-volume-up"></i>
                <i v-else>&nbsp;</i>
            </div>
            <div class="answer text-4xl">
                <span v-if="openAnswer">
                    {{ currentAnswer }}
                </span>
                <span v-else>
                    <i v-if="currentCard.irreg_verb" class="answer-hint">[Irregular Verb]</i>
                    <i v-else class="text-4xl">&nbsp;</i>
                </span>
            </div>
            <div class="buttons text-white mt-5">
                <span v-if="openAnswer">
                    <button class="bg-teal-100 hover:bg-teal-200 px-4 py-2 rounded" @click="computeAnswer(true)">Right :))</button>
                    <button class="bg-crimson-100 hover:bg-crimson-200 px-4 py-2 rounded"
                            @click="computeAnswer(false)">Wrong :(</button>
                    <button class="bg-gray-100 hover:bg-gray-300 px-4 py-2 text-black rounded"
                            @click="currentCard.favourite = !currentCard.favourite"><i
                        class="far fa-heart" :class="[currentCard.favourite ? 'fas' : 'far']"></i></button>
                </span>
                <span v-else>
                    <button class="bg-teal-100 text-white hover:bg-teal-200 px-4 py-2 rounded" @click="showAnswer">Show Answer</button>
                </span>
            </div>
        </div>
        <div class="arrows text-2xl mt-24 text-center flex justify-between">
            <button class="text-white hover:bg-gray-300 px-4 py-2 hover:text-black rounded" @click="_decreaseCardIndex">
                <
            </button>
            <button class="text-white hover:bg-gray-300 px-4 py-2 hover:text-black rounded" @click="_increaseCardIndex">
                >
            </button>
        </div>
    </div>
</template>
<script>
    import LaravelRoutes from '../mixins/laravel-routes';

    export default {
        props: [
            'cards',
            'envUnique',
            'mode'
        ],
        mixins: [LaravelRoutes],
        data() {
            return {
                cardIndex: 0,
                lastCardsIndex: 0,
                totalCards: 0,

                currentCard: {},
                currentQuestionLang: null,
                currentQuestion: '',
                currentAnswer: '',

                openAnswer: false,
                progressWidth: 0,

                synth: window.speechSynthesis,
                message: new window.SpeechSynthesisUtterance()
            }
        },
        mounted() {
            this.totalCards = (this.cards.length);
            this.lastCardsIndex = (this.cards.length - 1);
            this.currentCard = this.cards[this.cardIndex];

            this.message.voiceURI = 'native';
            this.message.volume = 1; // 0 to 1
            this.message.rate = 1; // 0.1 to 10
            this.message.pitch = 2; //0 to 2
            this.message.lang = 'en-US';

            this.cardInitAndShow();
        },
        watch: {
            /**
             * Init and Show Card
             *
             * @param currentCardIndex
             */
            cardIndex(currentCardIndex) {
                this.cardInitAndShow();

                if (currentCardIndex >= this.lastCardsIndex) {
                    this.endLesson();
                }
            }
        },
        methods: {
            /**
             *
             *
             */
            cardInitAndShow() {
                this.openAnswer = false;
                this.currentCard = this.cards[this.cardIndex];

                if (this.languageQuestion() === 'rus') {
                    this.currentQuestion = this.currentCard.rus;
                    this.currentAnswer = this.currentCard.eng;
                    this.currentQuestionLang = 'rus';
                } else {
                    this.currentQuestion = this.currentCard.eng;
                    this.currentAnswer = this.currentCard.rus;
                    this.currentQuestionLang = 'eng';
                }

                if (this.$store.state.listeningMode) {
                    this.speech();
                }

                window.addEventListener('keyup', this._respondQuestion);
            },

            /**
             * Show hidden div
             */
            showAnswer(event) {
                this.openAnswer = true;

                if (!this.$store.state.listeningMode) {
                    this.speech();
                }

                window.addEventListener('keyup', this._respondAnswer);
            },

            /**
             * Mark this card as new level and show new card
             *
             * @param answerIsCorrect
             */
            computeAnswer(answerIsCorrect) {
                let data = {
                    isCorrect: answerIsCorrect,
                    isFavourite: this.currentCard.favourite
                };

                // if card going to "Unique" play sound
                if (answerIsCorrect && ((this.currentCard.right + 1) - this.currentCard.wrong) >= this.envUnique) {
                    this.playDingSound();
                }

                axios.post(this.route('work.set_level', this.currentCard.id), data)
                    .catch((error) => {
                        this.playErrorSound();
                    });

                this._increaseCardIndex();
                this.progressWidth = Math.round(this.cardIndex * 100 / this.lastCardsIndex);
            },

            /**
             * Speech the text
             */
            speech() {
                // Remove all tips which are placed in the square brackets [].
                this.message.text = this.currentCard.eng.replace(/\[(.)*\]/gi, '...').replace(/\//gi, '...');

                this.synth.speak(this.message);
            },

            /**
             * Play Ding Sound
             */
            playDingSound() {
                this._playSound(new Audio("/ding-sound-effect.mp3"));
            },

            /**
             * Play  Error Sound
             */
            playErrorSound() {
                this._playSound(new Audio("/error-alert.mp3"));
            },

            /**
             * Play Sound
             *
             * @private
             */
            _playSound(audio) {
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
                        this.computeAnswer(false);
                        break;
                    case 'Space':
                        this.computeAnswer(true);
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
                        this._decreaseCardIndex();
                        this.showAnswer();
                        break;
                    default :
                        return;
                }

                window.removeEventListener("keyup", this._respondQuestion);
            },

            /**
             * Just decrease card index correctly
             *
             * @private
             */
            _decreaseCardIndex() {
                if (this.cardIndex > 0) {
                    this.cardIndex--;
                }
            },

            /**
             * Just decrease card index
             *
             * @private
             */
            _increaseCardIndex() {
                this.cardIndex++;
            },

            /**
             * What's language will be in question
             * depends on params or random
             *
             */
            languageQuestion() {
                /**
                 * is setting were applied
                 */
                if (this.$store.state.showOnly === '0' || this.$store.state.listeningMode || (this.currentCard.show_only === 0 || this.currentCard.show_only === '0')) {
                    return 'eng'
                } else if (this.$store.state.showOnly === '1' || (this.currentCard.show_only === 1 || this.currentCard.show_only === '1')) {
                    return 'rus'
                    /**
                     * else - random
                     */
                } else {
                    if (!Math.round(Math.random())) {
                        return 'eng'
                    } else {
                        return 'rus'
                    }
                }
            },

            /**
            *
            */
            endLesson() {
                this.endLessonPrompt();
            },

            /**
             *
             */
            endLessonPrompt(){
                this.$confirm({
                    title: 'Congratulations!',
                    message: `Lesson complete! Do you want to update all cards?`,
                    button: {
                        no: 'No!',
                        yes: 'Yes!'
                    },
                    /**
                     * Callback Function
                     * @param {Boolean} confirm
                     */
                    callback: confirm => {
                        if (confirm) {
                            location.href = this.route('work.end');
                        } else {
                            location.href = this.route('home');
                        }
                    }
                });
            },
        },
        computed: {

            /**
             * Calculate Diagram widths
             * use math proportions
             *
             */
            correctAnswersPercentage() {

                /**
                 * "if" solving problem when total eq 0
                 */
                if (this.currentCard.total) {
                    return this.currentCard.right * 100 / this.currentCard.total;
                } else {
                    return 0;
                }
            },

            /**
             * Calculate Diagram widths
             * use math proportions
             *
             */
            wrongAnswersPercentage() {

                /**
                 * "if" solving problem when total eq 0
                 */
                if (this.currentCard.total) {
                    return this.currentCard.wrong * 100 / this.currentCard.total;
                } else {
                    return 0;
                }
            },

            knowledgeMeterValue() {
                return (this.currentCard.right - this.currentCard.wrong);
            }
        },
    }
</script>


