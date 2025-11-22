<?php
namespace Observer;
use Domain\Inscricao;

class ConfirmacaoEmailObserver implements Observer {
    // 🚨 Agora o argumento $inscricao será do tipo correto Domain\Inscricao
    public function update(Inscricao $inscricao): void {
        // Acessa o nome através do objeto Inscricao
        $nome = $inscricao->getParticipante()->getNome(); 
        echo "Observer EMAIL: Enviando e-mail de confirmação para {$nome}.<br>";
    }
}