<template>
    <div>
        <div class="progress work-progress">
            <div class="progress-bar" role="progressbar" :style="{ width : progressWidth + '%' }" aria-valuemin="0"
                 aria-valuemax="100">&nbsp;{{ ( cardIndex + 1 ) }} / {{ totalCards }}
            </div>
        </div>
        <div class="work-content">
            <div class="statistic">
                <div v-if="openAnswer" class="progress statistic-progress">
                    <div class="progress-bar right" role="progressbar"
                         :style="{ width : correctAnswersPercentage +'%' }" aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                    <div class="progress-bar wrong" role="progressbar" :style="{ width : wrongAnswersPercentage + '%' }"
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="question w-100 text-6xl">
                <h1>{{ currentQuestion }} <span v-if="currentCard.category"><i :class="currentCard.category.icon_path"></i></span></h1>
            </div>
            <div class="answer w-100 text-5xl">
                <div v-if="openAnswer">
                    <h2><span>{{ currentAnswer }}</span></h2>
                </div>
                <div v-else>
                    <i v-if="currentCard.irreg_verb" class="answer-hint">[Irregular Verb]</i>
                    <i v-else class="answer-hint">&nbsp;</i>
                </div>
            </div>
            <div class="buttons w-100 mt-3">
                <div v-if="openAnswer" class="answer-buttons">
                    <button type="button" class="btn btn-info" @click="sendAnswerData(1, true)">Right :))</button>
                    <button type="button" class="btn btn-danger" @click="sendAnswerData(1, false)">Wrong :(</button>
                    <button type="button" class="btn btn-light" @click="currentCard.favourite = !currentCard.favourite">
                        <i class="far fa-heart" :class="[currentCard.favourite ? 'fas' : 'far']"></i>
                    </button>
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

    export default {
        props: [
            'cards',
            'envUnique'
        ],
        mixins: [LaravelRoutes],
        data() {
            return {
                cardIndex: 0,
                lastCardsIndex: 0,
                totalCards: 0,
                currentCard: {},
                currentQuestion: '',
                currentAnswer: '',
                openAnswer: false,
                progressWidth: 0,
                showAdditionalButtons: false,
                randMeasureRus: 0,
                randMeasureEng: 0,
            }
        },
        mounted() {
            this.totalCards = (this.cards.length);
            this.lastCardsIndex = (this.cards.length - 1);
            this.currentCard = this.cards[this.cardIndex];
            this.showQuestion();
        },
        methods: {
            showQuestion() {

                /**
                 * Check if all cards showed just redirect to homepage
                 */
                if (!this.totalCards || this.cardIndex > this.lastCardsIndex) {
                    location.href = this.route('work.end');
                }

                this.openAnswer = false;

                /**
                 * Random show Eng or Rus word
                 */
                if (Math.round(Math.random())) {
                    this.currentQuestion = this.currentCard.rus;
                    this.currentAnswer = this.currentCard.eng;
                    this.randMeasureRus++;

                } else {
                    this.currentQuestion = this.currentCard.eng;
                    this.currentAnswer = this.currentCard.rus;
                    this.randMeasureEng++;
                }

                window.addEventListener('keyup', this._respondQuestion);
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
                let data = {
                    isCorrect: isCorrect,
                    isFavourite: this.currentCard.favourite,
                    forcedLevel: level,
                };

                // if card going to "Unique" play sound
                if(isCorrect && (this.currentCard.right + 1) - this.currentCard.wrong >= this.envUnique){
                    this._playSound();
                }

                axios.post(this.route('work.set_level', this.currentCard.id), data).then(response => {
                    if (!response.data.errors) {
                        // ... we can do something here
                    } else {
                        // ... if we get "error", we can switch script to offline mode here (without statistic)
                    }
                });

                this.cardIndex++;
                this.progressWidth = Math.round(this.cardIndex * 100 / this.lastCardsIndex);
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
            }
        },
        watch: {

            /**
             * Show current card
             *
             * @param cardIndex
             */
            cardIndex(cardIndex) {
                this.currentCard = this.cards[cardIndex];
                this.showQuestion();
            }
        }
    }
</script>
