import createPersistedState from "vuex-persistedstate";
export default {
    state: {
        leftSidebarHide: true,
        showOnly: false,
        listeningMode: false,
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
    },
    plugins: [createPersistedState()],
}
