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


graph TD
    subgraph Padrao Strategy
        I[Inscricao (Context)];
        S{PrecoStrategy};
        SA[AlunoStrategy];
        SP[ProfissionalStrategy];

        I --> |injeta| S;
        S --> SA;
        S --> SP;
    end

    subgraph Padrao Observer
        O[Observer];
        OE[EmailObserver];
        OL[LogObserver];
        
        I --> |notifica| O;
        O --> OE;
        O --> OL;
    end
    
    subgraph Padrao Decorator
        D[Desconto];
        CD[CupomDecorator];
        IM[IsencaoMonitor];

        D --> |embrulha| CD;
        CD --> IM;
        
        I -- implementa --> D;
    end

## 🚀 Como Rodar e Testar

O projeto utiliza um arquivo de teste via Command Line Interface (CLI) para provar o funcionamento dos padrões.

### 1. Pré-requisitos

* PHP 7.4+ instalado e configurado.
* Acesso ao terminal/CLI na pasta raiz do projeto (`/EventoAcademico/`).

### 2. Execução e Validação dos Testes

1.  Abra o terminal na pasta raiz do projeto.
2.  Execute o script de teste:

    ```bash
    php app/cli_test.php
    ```

**Validação da Saída:**

| Requisito de Teste | Prova na Saída CLI | Padrão Validado |
| :--- | :--- | :--- |
| **Strategy (Preço Base)** | Preço Base deve mudar de **R$ 250,00** para **R$ 200,00** (Strategy Aluno) ou **R$ 225,00** (Strategy Profissional). | Strategy |
| **Composição de Decorators** | O Preço Final (Cupom + Isenção) deve ser **R$ 0,00**, provando a aplicação da cadeia de descontos em camadas. | Decorator |
| **Unicidade do Singleton** | O terminal confirma **`SUCESSO! Ambas as instâncias são iguais (Unicidade).`**. | Singleton |
| **Observer (Desacoplamento)** | O terminal imprime o `Observer EMAIL` e o `Observer LOG` logo após a notificação, provando que as ações secundárias foram disparadas. | Observer |