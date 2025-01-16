<template>
    <div class="dashboard">
        <h1>Dashboard</h1>
        <div class="filters">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter" v-model="statusFilter" @change="fetchTravelOrders">
                <option value="">All</option>
                <option value="solicitado">Solicitado</option>
                <option value="aprovado">Aprovado</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Applicant</th>
                    <th>Destination</th>
                    <th>Departure Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in travelOrders" :key="order.id">
                    <td>{{ order.id }}</td>
                    <td>{{ order.applicant_name }}</td>
                    <td>{{ order.destination }}</td>
                    <td>{{ order.departure_date }}</td>
                    <td>{{ order.return_date }}</td>
                    <td>{{ order.status }}</td>
                    <td>
                        <button @click="updateStatus(order.id, 'aprovado')">Approve</button>
                        <button @click="updateStatus(order.id, 'cancelado')">Cancel</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { updateTravelOrderStatus, fetchTravelOrders } from '@/services/api';

export default {
    name: 'DashboardView',
    data() {
        return {
            travelOrders: [],
            statusFilter: '',
        };
    },
    methods: {
        async fetchTravelOrders() {
            try {
                const response = await fetchTravelOrders({ status: this.statusFilter });
                this.travelOrders = response.data;
            } catch (error) {
                console.error('Error fetching travel orders:', error);
            }
        },
        async updateStatus(orderId, status) {
            try {
                await updateTravelOrderStatus(orderId, status);
                this.fetchTravelOrders();
            } catch (error) {
                console.error('Error updating status:', error);
            }
        },
    },
    mounted() {
        if (this.$store.getters.isAuthenticated) {
            this.$store.dispatch('fetchTravelOrders');
        }
    },
    computed: {
        travelOrdersfunc() {
            return this.$store.getters.getTravelOrders;
        },
    },
};
</script>

<style scoped>
.dashboard {
    padding: 20px;
}

.filters {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

td button {
    margin-right: 5px;
}
</style>