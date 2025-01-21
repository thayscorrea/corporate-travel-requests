<template>
    <MenuView />
    <div class="create-order">
        <h1>Criar pedido de viagem</h1>
        <form @submit.prevent="createOrder">
            <div class="form-group">
                <label for="applicant_name">Nome do solicitante:</label>
                <input type="text" id="applicant_name" v-model="order.applicant_name" @input="fetchUsers" required />
                <ul v-if="suggestedUsers.length > 0">
                    <li v-for="user in suggestedUsers" :key="user.id" @click="selectUser(user)">
                        {{ user.name }}
                    </li>
                </ul>
            </div>

            <div class="form-group">
                <label for="destination">Destino:</label>
                <input type="text" id="destination" v-model="order.destination" required />
            </div>

            <div class="form-group">
                <label for="departure_date">Data de ida:</label>
                <input type="date" id="departure_date" v-model="order.departure_date" required />
            </div>

            <div class="form-group">
                <label for="return_date">Data de volta:</label>
                <input type="date" id="return_date" v-model="order.return_date" required />
            </div>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</template>

<script>
import { createTravelOrder } from '@/services/api';
import MenuView from '@/components/MenuView.vue';


export default {
    name: 'CreateOrder',
    components: {
        MenuView,
    },
    data() {
        return {
            order: {
                applicant_name: '',
                destination: '',
                departure_date: '',
                return_date: '',
            },
            suggestedUsers: []
        };
    },
    methods: {
        async fetchUsers() {
            if (this.order.applicant_name.length > 2) { // Start fetching after 2 characters
                try {
                    const response = await fetch(`/users?name=${this.order.applicant_name}`);
                    const data = await response.json();
                    this.suggestedUsers = data;
                } catch (error) {
                    console.error('Error fetching users:', error);
                }
            } else {
                this.suggestedUsers = [];
            }
        },
        selectUser(user) {
            this.order.applicant_name = user.name;
            this.suggestedUsers = [];
        },
        async createOrder() {
            try {
                await createTravelOrder(this.order);
                this.$store.dispatch('showAlert', { message: 'Pedido de viagem criado com sucesso!', type: 'success' });

                this.$router.push('/dashboard'); // Redirect to Dashboard
            } catch (error) {
                console.error('Error creating order:', error);
                this.$store.dispatch('showAlert', { message: 'Falha ao criar pedido de viagem. Por favor, tente novamente.', type: 'error' });
            }
        },
    },
};
</script>

<style scoped>
.create-order {
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    text-align: left;
}

input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>