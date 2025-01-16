<template>
    <div class="create-order">
        <h1>Create Travel Order</h1>
        <form @submit.prevent="createOrder">
            <div class="form-group">
                <label for="applicant_name">Applicant Name:</label>
                <input type="text" id="applicant_name" v-model="order.applicant_name" required />
            </div>

            <div class="form-group">
                <label for="destination">Destination:</label>
                <input type="text" id="destination" v-model="order.destination" required />
            </div>

            <div class="form-group">
                <label for="departure_date">Departure Date:</label>
                <input type="date" id="departure_date" v-model="order.departure_date" required />
            </div>

            <div class="form-group">
                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" v-model="order.return_date" required />
            </div>

            <button type="submit">Create Order</button>
        </form>
    </div>
</template>

<script>
import { createTravelOrder } from '@/services/api';

export default {
    name: 'CreateOrder',
    data() {
        return {
            order: {
                applicant_name: '',
                destination: '',
                departure_date: '',
                return_date: '',
            },
        };
    },
    methods: {
        async createOrder() {
            try {
                await createTravelOrder(this.order);
                alert('Order created successfully!');
                this.$router.push('/dashboard'); // Redirect to Dashboard
            } catch (error) {
                console.error('Error creating order:', error);
                alert('Failed to create order. Please try again.');
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