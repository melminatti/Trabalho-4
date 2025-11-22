<?php
namespace Strategies;

interface PrecoStrategy {
    public function calcularPreco(float $precoBase): float;
}