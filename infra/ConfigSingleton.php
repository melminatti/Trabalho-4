<?php
namespace Infra;

// Implementação do Singleton para gerenciar configurações globais
final class ConfigSingleton {
    private static ?ConfigSingleton $instance = null;
    private array $settings = [];

    // 1. Construtor privado: impede a criação via new ConfigSingleton()
    private function __construct() {
        // Simula o carregamento de um arquivo de configuração
        $this->settings['lote_atual'] = 'Early';
        $this->settings['imposto'] = 0.15;
    } 
    
    // 2. Método estático para acesso global
    public static function getInstance(): ConfigSingleton {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // 3. Métodos essenciais (opcionalmente privados) para evitar clonagem/deserialização
    public function __clone() {}
    public function __wakeup() {}

    public function getSetting(string $key): mixed {
        return $this->settings[$key] ?? null;
    }
}