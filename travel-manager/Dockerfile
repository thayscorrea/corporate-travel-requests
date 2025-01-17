# Usar imagem base do Node.js
FROM node:16

# Definir diretório de trabalho
WORKDIR /app

# Copiar arquivos do projeto
COPY package*.json ./

# Instalar dependências
RUN npm install

# Copiar o restante do projeto
COPY . .

# Expor porta
EXPOSE 8080

# Iniciar o servidor de desenvolvimento
CMD ["npm", "run", "serve"]
