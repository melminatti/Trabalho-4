<?php
namespace Decorators;

// Aplica 5% de desconto adicional sobre o valor que já passou.
class CupomDesconto extends DescontoDecorator {
    public function getValor(float $precoBase): float {
        // Chama o objeto embrulhado (Decorator ou a Inscrição base)
        $valorAtual = $this->desconto->getValor($precoBase); 
        
        // Aplica o desconto do cupom sobre o valor atual
        return $valorAtual * 0.95; // 5% a menos
    }
}