🏛️ Projeto: Sistema de Inscrições em Eventos Acadêmicos (Design Patterns)

## 🎯 Problema e Objetivo

O projeto simula um sistema de processamento de inscrições que exige **flexibilidade** na aplicação de preços e **desacoplamento** nas notificações.

**Objetivo:** Implementar um sistema que possa:
1. **Calcular dinamicamente** o preço base (Strategy).
2. **Aplicar descontos cumulativos** (Decorator).
3. **Disparar ações secundárias** (e-mail, log) sem travar a lógica principal (Observer).
4. **Gerenciar recursos globais** (Singleton).

---

## 💡 Padrões de Projeto Escolhidos e Justificativa

| Padrão | Tipo | Função no Sistema | Porquê Foi Escolhido (Justificativa) |
| :--- | :--- | :--- | :--- |
| **Strategy** | Comportamental | **Cálculo do Preço Base.** Define o algoritmo de desconto (e.g., Aluno 20% vs. Profissional 10%). | Permite a **troca dinâmica** do algoritmo de precificação (Lote/Perfil) sem modificar a classe `Inscricao` (o contexto). |
| **Decorator** | Estrutural | **Aplicação de Descontos Cumulativos** (Cupons, Isenção Monitor). | Essencial para **compor descontos** (empilhar regras) de forma flexível e transparente, mantendo o princípio Open/Closed. |
| **Observer** | Comportamental | **Notificação Pós-Confirmação.** Dispara ações secundárias como envio de e-mail e registro de log. | Garante o **desacoplamento** entre a ação principal (`confirmar()`) e as reações (e-mail/log), tornando o sistema mais fácil de manter. |
| **Singleton** | Criacional | **Gerenciamento de Configuração Global.** | Garante que haja apenas uma instância da classe de configuração (`ConfigSingleton`), evitando inconsistências na leitura de dados de ambiente. |

---

## 📁 Estrutura do Projeto

O projeto segue a estrutura recomendada para Design Patterns:

/EventoAcademico/├── /app/             (Scripts de execução e testes)├── /domain/          (Entidades e Interfaces Base: Inscricao, Desconto)├── /strategies/      (Lógica de Preço)├── /decorators/      (Lógica de Desconto)├── /observers/       (Mecanismos de Reação)├── /infra/           (Singleton)└── /tests/           (Testes Unitários)
## 📐 Diagrama Simples (Mermaid)

```mermaid
graph TD
    subgraph Padrao Strategy
        I[Inscricao (Context)] --> |injeta| S{PrecoStrategy};
        S --> SA[AlunoStrategy];
        S --> SP[ProfissionalStrategy];
    end

    subgraph Padrao Observer
        I --> |notifica| O[Observer];
        O --> OE[EmailObserver];
        O --> OL[LogObserver];
    end
    
    subgraph Padrao Decorator
        D[Desconto] --> |embrulha| CD[CupomDecorator];
        CD --> IM[IsencaoMonitor];
    end

    I -- implementa --> D
🚀 Como Rodar e TestarO projeto utiliza um arquivo de teste via Command Line Interface (CLI) para provar o funcionamento dos padrões.1. ExecuçãoAbra o terminal na pasta raiz do projeto (/EventoAcademico/).Execute o script de teste:Bashphp app/cli_test.php
2. Validação dos Testes ObrigatóriosRequisito de TesteProva na Saída CLIPadrão ValidadoTroca Dinâmica de StrategiesPreço Base muda de R$ 200,00 (Strategy Aluno) para R$ 225,00 (Strategy Profissional).StrategyComposição de DecoratorsO Preço Final (Cupom + Isenção) é R$ 0,00, provando a aplicação da cadeia de descontos em camadas.DecoratorUnicidade do SingletonA saída confirma SUCESSO! Ambas as instâncias são iguais (Unicidade)..SingletonObserver (Desacoplamento)O terminal imprime o Observer EMAIL e o Observer LOG logo após a notificação, provando que as ações secundárias foram disparadas.