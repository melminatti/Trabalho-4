<?php
// Interface base que define o método getValor()
namespace Domain;

interface Desconto {
    public function getValor(float $precoBase): float;
}