<template>
    <div v-if="visible" :class="`alert alert-${type}`">
        <p>{{ message }}</p>
        <button @click="closeAlert">X</button>
    </div>
</template>

<script>
export default {
    name: 'AlertView',
    props: {
        type: {
            type: String,
            default: 'success', // Tipos: 'success', 'error'
        },
        message: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            visible: true,
        };
    },
    methods: {
        closeAlert() {
            this.visible = false;
        },
    },
};
</script>

<style scoped>
.alert {
    padding: 10px 20px;
    margin: 10px 0;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

button {
    background: none;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}
</style>