<template>
    <div class="last-report">
        <p class="text-center text-2xl">Last Report</p>
        <div class="flex justify-center text-sm md:text-base items-center pt-5 pb-2">
            <div class="px-5">
                <ul>
                    <li><span class="dot bg-new"></span> New: {{ resultData.new }}</li>
                    <li><span class="dot bg-normal"></span> Normal: {{ resultData.normal }}</li>
                    <li><span class="dot bg-magic"></span> Magic: {{ resultData.magic }}</li>
                    <li><span class="dot bg-rare"></span> Rare: {{ resultData.rare }}</li>
                    <li><span class="dot bg-unique"></span> Unique: {{ resultData.unique }}</li>
                </ul>
            </div>
            <div class="px-5 ml-6">
                <ul>
                    <li><span class="dot bg-teal-200"></span> Right: {{ lastReport.right }} <b>({{ rightPercentage }}%)</b></li>
                    <li><span class="dot bg-crimson-200"></span> Wrong: {{ lastReport.wrong }} <b>({{ wrongPercentage }}%)</b></li>
                    <li><span class="dot bg-gray-400"></span> Total: {{ lastReport.total }}</li>
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
        computed : {
            rightPercentage(){
                return Math.round( 100 / this.lastReport.total * this.lastReport.right);
            },
            wrongPercentage(){
                return Math.round(100 / this.lastReport.total * this.lastReport.wrong);
            }
        }
    }
</script>
