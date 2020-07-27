<template>
    <div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" :style="{ width : progressWidth + '%' }" aria-valuemin="0"
                 aria-valuemax="100">{{ (this.cardIndex + 1) }} / {{ this.totalCards }}
            </div>
        </div>
        <div class="text-center">
            <div class="question w-100">
                <h1>{{ this.currentQuestion }}</h1>
            </div>
            <div class="answer w-100">
                <h2 v-if="this.showAnswer"><span>{{ this.currentAnswer }}</span></h2>
                <h2 v-else>&nbsp;</h2>
            </div>
            <div class="buttons w-100">
                <div v-if="this.showAnswer">
                    <button type="button" class="btn btn-light" @click="setNewLevel(1, true)">Ok!</button>
                    <button type="button" class="btn btn-primary" @click="setNewLevel(3, true)">Up Magic</button>
                    <button type="button" class="btn btn-warning" @click="setNewLevel(5, true)">Up Rare</button>
                    <button type="button" class="btn btn-danger" @click="setNewLevel(10, true)">Up Unique</button>
                    <button type="button" class="btn btn-dark" @click="setNewLevel(11, true)">Up Legendary</button>
                </div>
                <div v-else>
                    <button type="button" class="btn btn-info" @keyup.space="openAnswer" @click="openAnswer">Show
                    </button>
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
        data: function () {
            return {
                cardIndex: 0,
                lastCardsIndex: 0,
                totalCards: 0,
                currentQuestion: '',
                currentAnswer: '',
                showAnswer: false,
                progressWidth: 0,
            }

        },
        mounted() {
            this.totalCards = (this.cards.length);
            this.lastCardsIndex = (this.cards.length - 1);
            this.showCard();
        },
        methods: {
            showCard() {

                /**
                 * Check if all cards showed just redirect to homepage
                 */
                if (!this.totalCards || this.cardIndex > this.lastCardsIndex) {
                    location.href = this.route('home');
                }

                this.showAnswer = false;

                /**
                 * Random show Eng or Rus word
                 */
                if (Math.round(Math.random())) {
                    this.currentQuestion = this.cards[this.cardIndex]['rus'];
                    this.currentAnswer = this.cards[this.cardIndex]['eng'];

                } else {
                    this.currentQuestion = this.cards[this.cardIndex]['eng'];
                    this.currentAnswer = this.cards[this.cardIndex]['rus'];
                }

                /*
                document.addEventListener('keyup', (event) => {
                    if (event.defaultPrevented) {
                        return;
                    }

                    console.log(event.code);

                    if (event.code === 'Escape') {
                        this.setNewLevel(1, false);
                        event.defaultPrevented;
                    } else if (event.code === 'Space') {
                        this.setNewLevel(1, true);
                        event.defaultPrevented;
                    } else if (event.code === 'Digit1') {
                        this.setNewLevel(3, true);
                        event.defaultPrevented;
                    }
                });


                 */
            },

            /**
             * Show hidden div
             */
            openAnswer(event) {
                event.preventDefault();
                this.showAnswer = true;
            },

            /**
             * Mark this card as new level
             *
             * @param level
             */
            setNewLevel(level, isCoreect) {
                let data = {
                    level: level,
                    isCoreect: isCoreect,
                };

                axios.post(this.route('work.set_level', this.cards[this.cardIndex].id), data).then(response => {
                    if (!response.data.errors) {
                    } else {
                    }
                });


                this.cardIndex++;
                this.progressWidth = Math.round(this.cardIndex * 100 / this.lastCardsIndex);
                this.showCard();
            }
        }


    }
</script>
