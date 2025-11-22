<?php
namespace Decorators;
use Domain\Desconto;

abstract class DescontoDecorator implements Desconto {
    // O objeto que será "decorado"
    protected Desconto $desconto; 

    public function __construct(Desconto $desconto) {
        $this->desconto = $desconto;
    }

    // Método abstrato que será implementado pelos decoradores concretos
    abstract public function getValor(float $precoBase): float;
}