<?php
namespace Strategies;

// Profissional tem 10% de desconto no preço base do lote
class ProfissionalStrategy implements PrecoStrategy {
    public function calcularPreco(float $precoBase): float {
        return $precoBase * 0.90; // 10% de desconto
    }
}