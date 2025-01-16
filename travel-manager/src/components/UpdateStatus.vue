<template>
    <div class="update-status">
        <h1>Update Order Status</h1>
        <form @submit.prevent="updateStatus">
            <div class="form-group">
                <label for="order_id">Order ID:</label>
                <input type="text" id="order_id" v-model="orderId" required />
            </div>

            <div class="form-group">
                <label for="status">New Status:</label>
                <select id="status" v-model="status" required>
                    <option value="">Select Status</option>
                    <option value="solicitado">Solicitado</option>
                    <option value="aprovado">Aprovado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>

            <button type="submit">Update Status</button>
        </form>
    </div>
</template>

<script>
import { updateTravelOrderStatus } from '@/services/api';

export default {
    name: 'UpdateStatus',
    data() {
        return {
            orderId: '',
            status: '',
        };
    },
    methods: {
        async updateStatus() {
            try {
                await updateTravelOrderStatus(this.orderId, this.status);
                alert('Order status updated successfully!');
                this.orderId = '';
                this.status = '';
            } catch (error) {
                console.error('Error updating status:', error);
                alert('Failed to update status. Please try again.');
            }
        },
    },
};
</script>

<style scoped>
.update-status {
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

input,
select {
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