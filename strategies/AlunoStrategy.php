<?php
namespace Strategies;

// Assumes PrecoStrategy is now defined in PrecoStrategy.php
class AlunoStrategy implements PrecoStrategy { 
    public function calcularPreco(float $precoBase): float {
        return $precoBase * 0.80;
    }
}