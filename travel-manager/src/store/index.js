import { createStore } from 'vuex';

const store = createStore({
    state: {
        token: localStorage.getItem('token') || null,
        user: null,
        travelOrders: [],
        alert: {
            message: '',
            type: '',
        },
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
        setAlert(state, { message, type }) {
            state.alert.message = message;
            state.alert.type = type;
        },
        clearAlert(state) {
            state.alert.message = '';
            state.alert.type = '';
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
        showAlert({ commit }, { message, type }) {
            commit('setAlert', { message, type });
            setTimeout(() => commit('clearAlert'), 5000); // Remove o alerta após 5 segundos
        },
    },
    getters: {
        isAuthenticated(state) {
            return !!state.token;
        },
        getTravelOrders(state) {
            return state.travelOrders;
        },
        alert(state) {
            return state.alert;
        },
    },
});

export default store;
