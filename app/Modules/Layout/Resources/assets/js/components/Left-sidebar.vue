<template>
    <nav id="left-sidebar" class="absolute left-0 top-0 h-full z-20 bg-white p-4 shadow-2xl"
         :class="{ hidden : $store.state.leftSidebarHide }" style="min-width: 360px;">
        <i class="fas fa-bars" @click="$store.dispatch('toggleLeftSidebarState')"></i>
        <h3 class="text-center text-2xl">Setting</h3>
        <hr class="mt-3"/>
        <div class="border-b">
            <h3 class="text-center text-lg">Work</h3>
            <ios-checkbox class="block pt-4 pl-4"
                          :value="$store.state.listeningMode"
                          :label="'Listening mode'"
                          @changed="$store.dispatch('toggleListeningMode', $event)"
            />
            <p>
                Show only
            </p>
            <select @change="$store.dispatch('showOnly', $event.target.value)" v-model="$store.state.showOnly">
                <option value="false">Off</option>
                <option value="0">Engl</option>
                <option value="1">Rus</option>
            </select>
        </div>
        <div class="border-b">
            <h3 class="text-center text-lg">Numbers</h3>
            <ios-checkbox class=" block pt-4 pl-4" :label="'Speaking mode'"/>
        </div>
        <div class="border-b">
            <a href="#">Shuffle</a>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {}
        },
        methods: {},
    }
</script>
