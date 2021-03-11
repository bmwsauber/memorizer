import createPersistedState from "vuex-persistedstate";
export default {
    state: {
        leftSidebarHide: true,
        showOnly: false,
        listeningMode: false,
        darkMode: false,
    },
    getters: {},
    actions: {
        toggleLeftSidebarState(store) {
            store.commit('toggleLeftSidebarState');
        },
        showOnly(store, param) {
            store.commit('showOnly', param);
        },
        toggleListeningMode(store, param){
            store.commit('toggleListeningMode', param);
        },
        toggleDarkMode(store, param){
            store.commit('toggleDarkMode', param);
        },
    },
    mutations: {
        toggleLeftSidebarState(state) {
            return state.leftSidebarHide = !state.leftSidebarHide;
        },
        showOnly(state, param) {
            return state.showOnly = param;
        },
        toggleListeningMode(state, param) {
            return state.listeningMode = param;
        },
        toggleDarkMode(state, param) {
            return state.darkMode = param;
        },
    },
    plugins: [createPersistedState()],
}
