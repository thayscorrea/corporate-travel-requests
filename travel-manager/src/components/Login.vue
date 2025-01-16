<template>
    <div class="auth-container">
        <div class="login">
            <h1>Login</h1>
            <form @submit.prevent="loginUser">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="loginEmail" required />
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" v-model="loginPassword" required />
                </div>

                <button type="submit">Login</button>
            </form>
        </div>

        <div class="register">
            <h1>Register</h1>
            <form @submit.prevent="registerUser">
                <div class="form-group">
                    <label for="register_name">Name:</label>
                    <input type="text" id="register_name" v-model="registerName" required />
                </div>

                <div class="form-group">
                    <label for="register_email">Email:</label>
                    <input type="email" id="register_email" v-model="registerEmail" required />
                </div>

                <div class="form-group">
                    <label for="register_password">Password:</label>
                    <input type="password" id="register_password" v-model="registerPassword" required />
                </div>

                <div class="form-group">
                    <label for="register_password_confirmation">Confirm Password:</label>
                    <input type="password" id="register_password_confirmation" v-model="registerPasswordConfirmation"
                        required />
                </div>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AuthContainer',
    data() {
        return {
            loginEmail: '',
            loginPassword: '',
            registerName: '',
            registerEmail: '',
            registerPassword: '',
            registerPasswordConfirmation: '',
        };
    },
    methods: {
        async loginUser() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.loginEmail,
                    password: this.loginPassword,
                });

                const token = response.data.access_token;
                this.$store.dispatch('saveToken', token); 
                alert('Login successful!');
                this.$router.push('/dashboard'); // Redirect to dashboard
            } catch (error) {
                console.error('Error during login:', error);
                alert('Login failed. Please check your credentials and try again.');
            }
        },
        async registerUser() {
            try {
                await axios.post('/api/register', {
                    name: this.registerName,
                    email: this.registerEmail,
                    password: this.registerPassword,
                    password_confirmation: this.registerPasswordConfirmation,
                });

                alert('Registration successful! You can now log in.');
                this.registerName = '';
                this.registerEmail = '';
                this.registerPassword = '';
                this.registerPasswordConfirmation = '';
            } catch (error) {
                console.error('Error during registration:', error);
                alert('Registration failed. Please try again.');
            }
        },
    },
};
</script>

<style scoped>
.auth-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    max-width: 900px;
    margin: 0 auto;
}

.login,
.register {
    width: 45%;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

h1 {
    text-align: center;
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
    width: 100%;
}

button:hover {
    background-color: #0056b3;
}
</style>