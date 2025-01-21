<template>
    <MenuView />
    <div class="dashboard">
        <h1>Dashboard</h1>
        <div class="filters">
            <label for="statusFilter">Filtrar por Status:</label>
            <select id="statusFilter" v-model="statusFilter" @change="applyFilter">
                <option value="">Todos</option>
                <option value="solicitado">Solicitado</option>
                <option value="aprovado">Aprovado</option>
                <option value="cancelado">Cancelado</option>
            </select>

            <label for="destinationFilter">Filtrar por Destino:</label>
            <input id="destinationFilter" v-model="destinationFilter" @input="applyFilter" placeholder="Digite o destino" />
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do solicitante</th>
                    <th>Destino</th>
                    <th>Data de ida</th>
                    <th>Data de volta</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading">
                    <td colspan="7">Carregando...</td>
                </tr>
                <tr v-if="!loading && filteredOrders.length === 0">
                    <td colspan="7">Nenhum dado encontrado.</td>
                </tr>
                <tr v-for="order in filteredOrders" :key="order.id">
                    <td>{{ order.id }}</td>
                    <td>{{ order.applicant_name }}</td>
                    <td>{{ order.destination }}</td>
                    <td>{{ order.departure_date }}</td>
                    <td>{{ order.return_date }}</td>
                    <td>{{ order.status }}</td>
                    <td>
                        <button class="button-ap" @click="updateStatus(order.id, 'aprovado')" :disabled="order.status === 'aprovado'">Aprovar</button>
                        <button class="button-rp" @click="updateStatus(order.id, 'cancelado')" :disabled="order.status === 'cancelado'">Cancelar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { updateTravelOrderStatus, fetchTravelOrders } from '@/services/api';
import MenuView from '@/components/MenuView.vue';

export default {
    name: 'DashboardView',
    components: {
        MenuView,
    },
    data() {
        return {
            travelOrders: [],
            statusFilter: '',
            destinationFilter: '',
            loading: false,
        };
    },
    computed: {
        filteredOrders() {
            let filtered = this.travelOrders;

            if (this.statusFilter) {
                filtered = filtered.filter(order => order.status === this.statusFilter);
            }

            if (this.destinationFilter) {
                filtered = filtered.filter(order => order.destination.toLowerCase().includes(this.destinationFilter.toLowerCase()));
            }

            return filtered;
        },
    },
    methods: {
        async fetchTravelOrders() {
            this.loading = true;
            try {
                const response = await fetchTravelOrders();
                this.travelOrders = response.data;
            } catch (error) {
                console.error('Erro ao buscar os pedidos de viagem:', error);
                this.travelOrders = [];
            } finally {
                this.loading = false;
            }
        },
        applyFilter() {
            // A filtragem é feita automaticamente pela propriedade computada "filteredOrders"
            console.log(`Filtro aplicado: Status - ${this.statusFilter}, Destino - ${this.destinationFilter}`);
        },
        async updateStatus(orderId, status) {
            try {
                const response = await updateTravelOrderStatus(orderId, status);
                this.fetchTravelOrders();
            } catch (error) {
                this.$store.dispatch('showAlert', { message: 'Não é possível cancelar um pedido aprovado!', type: 'error' });

                console.error('Erro ao atualizar o status do pedido de viagem:', error);
            }
        },
    },
    mounted() {
        this.fetchTravelOrders();
    },
};
</script>

<style scoped>
.dashboard {
    padding: 20px;
}

.filters {
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
    align-items: center;
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
    cursor: pointer;
}

.button-ap {
    background: green;
    color: white;
    border: none;
    padding: 3%;
    border-radius: 5px;
}

.button-rp {
    background:#9b0404;
    color: white;
    border: none;
    padding: 3%;
    border-radius: 5px;
}

.button-ap:disabled {
    background-color: #d3d3d3;
    cursor: not-allowed;
}

.button-rp:disabled {
    background-color: #d3d3d3;
    cursor: not-allowed;
}
</style>
