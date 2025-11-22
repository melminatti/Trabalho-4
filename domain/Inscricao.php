<?php
// Arquivo: domain/Inscricao.php

namespace Domain;

use Strategies\PrecoStrategy;
use Observer\Observer;

// A classe Inscricao atua como:
// 1. Contexto para o padrão Strategy (cálculo de preço).
// 2. Subject (Assunto) para o padrão Observer (notificação de alteração).
// 3. Componente Concreto para o padrão Decorator (objeto inicial de desconto).

class Inscricao implements Desconto {
    private Participante $participante;
    private string $tipo;
    private float $precoBase = 0.0;
    private array $observers = [];
    private PrecoStrategy $strategy;

    // 🚨 CORREÇÃO 1: O construtor agora recebe o objeto Participante, 
    // permitindo que o Observer acesse seus dados (nome/perfil).
   public function __construct(Participante $participante) {
    // 🚨 CORREÇÃO: Armazena o objeto Participante e extrai o tipo/perfil dele.
    $this->participante = $participante;
    $this->tipo = $participante->getPerfil(); // Pega 'ALUNO' ou 'PROFISSIONAL' do objeto
}

    // --- Métodos de Strategy ---

    // 🚨 CORREÇÃO 2: Adicionada a tipagem float para o $precoInicial 
    // e inclusão do parâmetro $precoInicial, resolvendo o TypeError no calcularPreco().
    public function setPrecoStrategy(PrecoStrategy $strategy, float $precoInicial): void {
        $this->strategy = $strategy;
        // Chama a Strategy com o preço float, não com a string $this->tipo
        $this->precoBase = $this->strategy->calcularPreco($precoInicial);
    }

    public function getPrecoBase(): float {
        return $this->precoBase;
    }

    // --- Métodos de Decorator (Interface Desconto) ---
    
    // Implementação da interface Desconto para ser o objeto base da decoração
    public function getValor(float $preco): float {
        // Retorna o preço base calculado pela Strategy
        return $this->precoBase;
    }

    // --- Métodos de Observer (Subject) ---

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        // Implementação de remoção se necessário, omitida para simplicidade
    }

   public function notify(): void {
    echo "Inscrição confirmada para {$this->participante->getNome()} {$this->tipo}<br>";
    
    // AQUI, o Observers deve receber o objeto $this para fazer a chamada correta
    foreach ($this->observers as $observer) {
        $observer->update($this); // Correto
    }
}

    // --- Getters Adicionais (Necessário para o Observer) ---

    // 🚨 CORREÇÃO 4: Adição do getter para Participante, resolvendo o erro 
    // Call to undefined method Domain\Inscricao::getParticipante()
    public function getParticipante(): Participante {
        return $this->participante;
    }

    public function getTipo(): string {
        return $this->tipo;
    }
    
    // Opcional: Adicionar um getter para o preço calculado após a Strategy
    public function getPrecoAposStrategy(): float {
        return $this->precoBase;
    }
}