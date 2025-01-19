<template>
    <header>
      <nav>
        <ul>
          <li><router-link to="/">Login</router-link></li>
          <li><router-link to="/dashboard">Dashboard</router-link></li>
          <li><router-link to="/create-order">Criar Pedido</router-link></li>
          <li><router-link to="/update-status">Atualizar Status</router-link></li>
        </ul>
      </nav>
    </header>
</template>

<style scoped>

header {
  background-color: #007bff;
  padding: 10px;
  color: white;
}

nav ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}

nav ul li {
  margin: 0 10px;
}

nav ul li a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

nav ul li a:hover {
  text-decoration: underline;
}

</style>