<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>Cards Statistic</p>
            </div>
            <div class="col-md-6">
                <GChart
                    class="google-charts"
                    type="PieChart"
                    :data="totalsData"
                    :options="totalsOptions"
                />
            </div>
            <div class="col-md-6">
                <GChart
                    class="google-charts"
                    type="PieChart"
                    :data="rightData"
                    :options="rightOptions"
                />
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'sortedCards',
            'cardsAmount',
            'rightSum',
            'wrongSum',
        ],
        data() {
            return {
                totalsData: [
                    ['Level', 'Amount'],
                    ['New: ' + this.sortedCards.new, this.sortedCards.new],
                    ['Normal: ' + this.sortedCards.normal, this.sortedCards.normal],
                    ['Magic: ' + this.sortedCards.magic, this.sortedCards.magic],
                    ['Rare: ' + this.sortedCards.rare, this.sortedCards.rare],
                    ['Unique: ' + this.sortedCards.unique, this.sortedCards.unique],
                ],
                totalsOptions: {
                    title: 'Cards Amount: ' + this.cardsAmount,
                    pieHole: 0.5,
                    //width: 600,
                    //height: 350,
                    colors: ['#28a745', '#aaaaaa', '#8383f7', '#f8b335', '#ba661d']
                },
                rightData: [
                    ['Answer', 'Amount'],
                    ['Right', this.rightSum],
                    ['Wrong', this.wrongSum],
                ],
                rightOptions: {
                    title: 'Total Answers: ' + (this.rightSum + this.wrongSum),
                    pieHole: 0.5,
                    //width: 600,
                    //height: 350,
                    colors: ['#117a8b', '#bd2130']
                }

            }
        },
    }
</script>
