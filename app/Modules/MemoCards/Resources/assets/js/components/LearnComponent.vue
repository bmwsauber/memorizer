<template>
    <div>
        <div class="progress work-progress">
            <div class="progress-bar" role="progressbar" :style="{ width : progressWidth + '%' }" aria-valuemin="0"
                 aria-valuemax="100">&nbsp;{{ ( cardIndex + 1 ) }} / {{ totalCards }}
            </div>
        </div>
        <div class="work-content">
            <div class="question w-100">
                <h1>{{ currentQuestion }}</h1>
            </div>
            <div class="answer w-100">
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
                    <button type="button" class="btn btn-info" @click="showNextCard()">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import LaravelRoutes from '../mixins/laravel-routes';

    export default {
        props: [
            'cards'
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
                openAnswer: true,
                progressWidth: 0,
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
                    location.href = this.route('home');
                }


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
             */
            showNextCard() {

                this.cardIndex++;
                this.currentCard = this.cards[this.cardIndex];
                this.progressWidth = Math.round(this.cardIndex * 100 / this.lastCardsIndex);
                this.showQuestion();
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
                        this.showNextCard();
                        break;
                    case 'Space':
                        this.showNextCard();
                        break;
                    case 'Backspace':
                        this.cardIndex--;
                        this.currentCard = this.cards[this.cardIndex];
                        this.showQuestion();
                        this.showAnswer();
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
                        this.currentCard = this.cards[this.cardIndex];
                        this.showQuestion();
                        this.showAnswer();
                        break;
                    default :
                        return;
                }

                window.removeEventListener("keyup", this._respondQuestion);
            },
        },
    }
</script>
