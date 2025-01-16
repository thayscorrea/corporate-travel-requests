import { createStore } from 'vuex';

const store = createStore({
    state: {
        token: localStorage.getItem('token') || null,
        user: null,
        travelOrders: [],
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        setUser(state, user) {
            state.user = user;
        },
        setTravelOrders(state, orders) {
            state.travelOrders = orders;
        },
    },
    actions: {
        saveToken({ commit }, token) {
            commit('setToken', token);
            localStorage.setItem('token', token);
        },
        clearToken({ commit }) {
            commit('setToken', null);
            localStorage.removeItem('token');
        },
        async fetchTravelOrders({ commit }) {
            const token = localStorage.getItem('token');
            if (token) {
                try {
                    const response = await fetch('/api/travel-orders', {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                    const data = await response.json();
                    commit('setTravelOrders', data);
                } catch (error) {
                    console.error('Error fetching travel orders:', error);
                }
            }
        },
    },
    getters: {
        isAuthenticated(state) {
            return !!state.token;
        },
        getTravelOrders(state) {
            return state.travelOrders;
        },
    },
});

export default store;
