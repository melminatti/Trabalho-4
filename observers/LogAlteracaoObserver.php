<?php
namespace Observer;
use Domain\Inscricao;

class LogAlteracaoObserver implements Observer {
    public function update(Inscricao $inscricao): void {
        // 🚨 CORREÇÃO: Usar o método getPrecoBase()
        $valor = $inscricao->getPrecoBase(); 
        
        $nome = $inscricao->getParticipante()->getNome();
        echo "Observer LOG: Inscrição #{$nome} - Preço base de R$ " . number_format($valor, 2, '.', ',') . " logado.<br>";
    }
}