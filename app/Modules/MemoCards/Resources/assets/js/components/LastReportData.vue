<template>
    <div class="last-report row justify-content-md-center">
        <div class="col-3 row">
            <p class="title col-12">Last Report Results</p>
            <div class="data col-6">
                <ul>
                    <li><span class="dot new"></span> New: {{ resultData.new }}</li>
                    <li><span class="dot normal"></span> Normal: {{ resultData.normal }}</li>
                    <li><span class="dot magic"></span> Magic: {{ resultData.magic }}</li>
                    <li><span class="dot rare"></span> Rare: {{ resultData.rare }}</li>
                    <li><span class="dot unique"></span> Unique: {{ resultData.unique }}</li>
                </ul>
            </div>
            <div class="statistic col-6">
                <ul>
                    <li><span class="dot right"></span> Right: {{ lastReport.right }} <b>({{ rightPercentage }}%)</b></li>
                    <li><span class="dot wrong"></span> Wrong: {{ lastReport.wrong }} <b>({{ wrongPercentage }}%)</b></li>
                    <li><span class="dot total"></span> Total: {{ lastReport.total }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'resultData',
            'lastReport'
        ],
        data() {
            return {

            }
        },
        computed : {
            rightPercentage(){
                return Math.round( 100 / this.lastReport.total * this.lastReport.right);
            },
            wrongPercentage(){
                return Math.round(100 / this.lastReport.total * this.lastReport.wrong);
            },
        },
        methods: {

        },
    }
</script>
