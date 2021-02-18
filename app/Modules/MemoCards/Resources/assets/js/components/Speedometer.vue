<template>
    <div class="">
        <GChart
            :settings="{ packages: ['corechart', 'gauge'] }"
            class=""
            type="Gauge"
            :data="totalsData"
            :options="totalsOptions"
        />
    </div>
</template>
<script>
    export default {
        props: [
            'correctVolume',
            'envUnique',
        ],
        data() {
            return {
                totalsData: [
                    ['Label', 'Value'],
                    ['Legendary', this.correctVolume],
                ],
                totalsOptions: {
                    min: (this.envUnique - this.envUnique * 2),
                    max: this.envUnique,
                    width: 400, height: 120,
                    redFrom: (this.envUnique - this.envUnique * 2), redTo:(this.envUnique - this.envUnique * 2) + 2,
                    greenFrom: (this.envUnique) - 2, greenTo: this.envUnique,
                    greenColor: '#117a8b',
                    redColor: '#bd2130',
                    minorTicks: 5
                }
            }
        },
        watch: {
            correctVolume(volume){
                this.totalsData = [
                    ['Label', 'Value'],
                    ['Legendary', this.correctVolume],
                ]
            }
        }
    }
</script>
