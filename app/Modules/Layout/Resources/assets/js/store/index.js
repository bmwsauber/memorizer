export default {

    state: {
        leftSidebarHide: true,
    },

    getters: {
    },

    actions: {
        toggleLeftSidebarState(store) {
            store.commit('toggleLeftSidebarState')
        }
    },
    mutations: {
        toggleLeftSidebarState(state) {
            return state.leftSidebarHide = !state.leftSidebarHide;
        }
    }
}
