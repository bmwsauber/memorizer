<template>
    <div class="flex flex-col justify-between absolute h-full w-full">
        <div class="progress-bar relative bg-gray-100 w-full h-7">
            <div class="absolute top-0-left-0 bg-teal-100 text-center h-7" :style="{ width : progressWidth + '%' }">
                <span class="text-white text-lg">{{ ( cardIndex + 1 ) }} / {{ totalCards }}</span>
            </div>
        </div>
        <div class="card-content text-center">
            <div class="color-bar flex justify-center">
                <speedometer
                    :correctVolume="correctWrongVolume"
                    :envUnique="envUnique"
                >
                </speedometer>

            </div>
            <div class="question text-5xl mt-6">
                <span>{{ currentQuestion }}</span>
                <span v-if="currentCard.category" class="text-4xl"> <i
                    :class="currentCard.category.icon_path"></i></span>
            </div>
            <div class="speaker text-4xl p-3 pt-4" @click="speech"><i
                v-if="(currentQuestionLang == 'eng' || mode == 'listening' || openAnswer)" class="fas fa-volume-up"></i>
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
                    <button class="bg-teal-100 hover:bg-teal-200 px-4 py-2 rounded" @click="sendAnswerData(1, true)">Right :))</button>
                    <button class="bg-crimson-100 hover:bg-crimson-200 px-4 py-2 rounded"
                            @click="sendAnswerData(1, false)">Wrong :(</button>
                    <button class="bg-gray-100 hover:bg-gray-300 px-4 py-2 text-black rounded"
                            @click="currentCard.favourite = !currentCard.favourite"><i
                        class="far fa-heart" :class="[currentCard.favourite ? 'fas' : 'far']"></i></button>
                </span>
                <span v-else>
                    <button class="bg-teal-100 text-white hover:bg-teal-200 px-4 py-2 rounded" @click="showAnswer">Show Answer</button>
                </span>
            </div>
        </div>
        <div class="balancer"></div>
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
                currentQuestion: '',
                currentAnswer: '',
                openAnswer: false,
                progressWidth: 0,
                showAdditionalButtons: false,
                randMeasureRus: 0,
                randMeasureEng: 0,
                currentQuestionLang: null,
                synth: window.speechSynthesis,
                message: new window.SpeechSynthesisUtterance(),
                correctVolume: 0,
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
                if (this.mode == 'listening' || (this.currentCard.show_only === 0 || this.currentCard.show_only === '0') || Math.round(Math.random())) { //not sure about the type of var
                    this.currentQuestion = this.currentCard.rus;
                    this.currentAnswer = this.currentCard.eng;
                    this.currentQuestionLang = 'rus';
                    this.randMeasureRus++;
                } else {
                    this.currentQuestion = this.currentCard.eng;
                    this.currentAnswer = this.currentCard.rus;
                    this.currentQuestionLang = 'eng';
                    this.randMeasureEng++;
                }

                if (this.mode == 'listening') {
                    this.speech();
                }

                window.addEventListener('keyup', this._respondQuestion);
            },

            /**
             * Show hidden div
             */
            showAnswer(event) {
                this.openAnswer = true;

                if (this.mode != 'listening') {
                    this.speech();
                }

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
                if (isCorrect && (this.currentCard.right + 1) - this.currentCard.wrong >= this.envUnique) {
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
             * Speech the text
             */
            speech() {
                this.message.text = this.currentCard.eng.replace(/\[(.)*\]/gi, '...').replace(/\//gi, '...');
                this.synth.speak(this.message);
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
            _trimNumber(rowValue, bounds) {
                let value;
                if(rowValue >= bounds){
                    value = bounds
                }else if(rowValue <= -bounds){
                    value = -bounds
                }else{
                    value = rowValue;
                }
                return value;
            }
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

            correctWrongVolume(){
                return this._trimNumber((this.currentCard.right - this.currentCard.wrong), this.envUnique);
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


