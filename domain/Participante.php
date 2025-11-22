<?php
// Entidade que será criada pela Factory (implícita)
namespace Domain;

class Participante {
    public function __construct(
        private string $nome,
        private string $perfil // 'aluno' ou 'profissional'
    ) {}

    public function getPerfil(): string {
        return $this->perfil;
    }
    public function getNome(): string {
        return $this->nome;
    }
}