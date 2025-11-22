<?php
namespace Observer;
use Domain\Inscricao;

interface Observer {
    public function update(Inscricao $inscricao): void;
}