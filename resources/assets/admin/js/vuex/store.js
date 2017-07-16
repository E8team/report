import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex)

const state = {
  departmentId: ''
}
export default new Vuex.Store({
  state,
  mutations: {
    UPDATE_DEPARTMENT_ID (state, departmentId) {
      state.departmentId = departmentId
    }
  }
})
