import Vuex from 'vuex'

// Vue.use(Vuex)

const state = {
  direction: 'forward'
}
export default new Vuex.Store({
  state,
  mutations: {
    UPDATE_DIRECTION (state, { direction }) {
      state.direction = direction
    }
  }
})
