import leftSidebar from "../components/Left-sidebar";
Vue.component('ios-checkbox', require('../components/parts/iosCheckbox').default);
import {shallowMount, RouterLinkStub, createLocalVue } from "@vue/test-utils";
import Vuex from 'vuex';
import Vue from "vue";
const localVue = createLocalVue()
localVue.use(Vuex);

describe("leftSidebar.vue", () => {

    let store;

    beforeEach(() => {
        store = new Vuex.Store();
    });

    it('test1', () => {
        let wrapper = shallowMount(leftSidebar, {
            localVue,
            store
        });

        let darkModelabel = wrapper.find('a').find('span');

        expect(darkModelabel.text()).toBe('Shuffle');

    })
});
