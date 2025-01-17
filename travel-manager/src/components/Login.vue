<template>
    <div class="auth-container">
        <div v-if="showLogin" class="login">
            <h1>Login</h1>
            <form @submit.prevent="loginUser">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="loginEmail" required />
                </div>

                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" v-model="loginPassword" required />
                </div>

                <div class="buttons">
                    <button type="submit">Login</button>
                </div>

                <p>
                    Não tem uma conta? <a href="#" @click="toggleView">Cadastre-se</a>
                </p>
            </form>
        </div>

        <div v-if="!showLogin" class="register">
            <h1>Cadastre-se</h1>
            <form @submit.prevent="registerUser">
                <div class="form-group">
                    <label for="register_name">Nome:</label>
                    <input type="text" id="register_name" v-model="registerName" required />
                </div>

                <div class="form-group">
                    <label for="register_email">Email:</label>
                    <input type="email" id="register_email" v-model="registerEmail" required />
                </div>

                <div class="form-group">
                    <label for="register_password">Senha:</label>
                    <input type="password" id="register_password" v-model="registerPassword" required />
                </div>

                <div class="form-group">
                    <label for="register_password_confirmation">Confirme a Senha:</label>
                    <input type="password" id="register_password_confirmation" v-model="registerPasswordConfirmation"
                        required />
                </div>

                <button type="submit">Cadastrar</button>

                <p>
                    Já tem sua conta? <a href="#" @click="toggleView">Login</a>
                </p>
            </form>
        </div>
    </div>
</template>

<script>
import { registerUser, loginUser } from '@/services/api';

export default {
    name: 'AuthContainer',
    data() {
        return {
            showLogin: true,
            loginEmail: '',
            loginPassword: '',
            registerName: '',
            registerEmail: '',
            registerPassword: '',
            registerPasswordConfirmation: '',
        };
    },
    methods: {
        toggleView() {
            this.showLogin = !this.showLogin;
        },
        async loginUser() {
            try {
                const response = await loginUser({ email: this.email, password: this.password });
                const token = response.data.access_token;
                this.$store.dispatch('saveToken', token);

                this.$store.dispatch('showAlert', { message: 'Login realizado com sucesso!', type: 'success' });

                setTimeout(() => this.$router.push('/dashboard'), 2000);
            } catch (error) {
                this.$store.dispatch('showAlert', { message: 'Erro ao realizar o login. Por favor, verifique suas credenciais e tente novamente.', type: 'error' });

                console.error('Error during login:', error);
            }
        },
        async registerUser() {
            try {
                await registerUser({
                    name: this.registerName,
                    email: this.registerEmail,
                    password: this.registerPassword,
                    password_confirmation: this.registerPasswordConfirmation,
                })

                this.$store.dispatch('showAlert', { message: 'Registro realizado com sucesso!', type: 'success' });
                this.registerName = '';
                this.registerEmail = '';
                this.registerPassword = '';
                this.registerPasswordConfirmation = '';
            } catch (error) {
                console.error('Error during registration:', error);
                this.$store.dispatch('showAlert', { message: 'Erro ao realizar o cadastro. Por favor, tente novamente.', type: 'error' });
            }
        },
    },
};
</script>

<style scoped>
.auth-container {
    display: flex;
    justify-content: center;
    padding: 20px;
    max-width: 900px;
    margin: auto;
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
    width: 100%;
    margin-bottom: 15px;
}

button:hover {
    background-color: #0056b3;
}

.buttons {
    margin-top: 30%;
}

a {
    color: #007bff;
    cursor: pointer;
    text-decoration: none;
}
</style>