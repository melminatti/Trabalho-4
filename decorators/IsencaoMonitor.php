<?php
namespace Decorators;

// Aplica Isenção Total (0% de custo)
class IsencaoMonitor extends DescontoDecorator {
    public function getValor(float $precoBase): float {
        // Monitor tem 100% de desconto, independente do valor anterior
        return 0.0; 
    }
}