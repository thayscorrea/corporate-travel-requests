<?php

return [
    'paths' => ['api/*', 'travel-manager/*', 'sanctum/csrf-cookie'],

    // Métodos HTTP permitidos (GET, POST, etc.)
    'allowed_methods' => ['*'],

    // Origens permitidas (onde o Vue.js está rodando)
    'allowed_origins' => ['http://localhost:8080'],

    // Padrões de origem permitidos (útil para subdomínios dinâmicos, se necessário)
    'allowed_origins_patterns' => [],

    // Cabeçalhos permitidos nas requisições
    'allowed_headers' => ['*'],

    // Cabeçalhos expostos na resposta
    'exposed_headers' => [],

    // Tempo em segundos para cache das configurações
    'max_age' => 0,

    // Habilitar suporte a credenciais (como cookies e autenticação baseada em sessão)
    'supports_credentials' => false,
];
