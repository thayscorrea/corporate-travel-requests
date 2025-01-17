import axios from 'axios';

// Cria uma instância do Axios
const api = axios.create({
    baseURL: 'http://localhost:9001/api', // Substitua pelo endpoint da sua API Laravel
    headers: {
        'Content-Type': 'application/json',
    },
});

// Adiciona o token JWT aos cabeçalhos
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;


export async function createTravelOrder(orderData) {
    return api.post('/travel-orders', orderData);
}

export async function updateTravelOrderStatus(orderId, status) {
    return api.patch(`/travel-orders/${orderId}/status`, { status });
}

export async function fetchTravelOrders(filters = {}) {
    return api.get('/travel-orders', { params: filters });
}

export async function registerUser(credentials) {
    return api.post('/register', credentials);
}

export async function loginUser(credentials) {
    return api.post('/login', credentials);
}

export async function logoutUser() {
    return api.post('/logout');
}

// import { logoutUser } from '@/services/api';

// async logout() {
//   try {
//     await logoutUser();
//     localStorage.removeItem('token');
//     alert('Logout successful!');
//     this.$router.push('/');
//   } catch (error) {
//     console.error('Error during logout:', error);
//     alert('Failed to log out. Please try again.');
//   }
// }