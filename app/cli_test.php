<?php
// Arquivo: app/cli_test.php - Execução dos Design Patterns

// --- INCLUSÃO DE INTERFACES E CLASSES NA ORDEM CORRETA ---

// 🚨 1. Interfaces de Domínio (Carregadas PRIMEIRO)
require_once __DIR__ . '/../domain/Desconto.php'; // Interface base do Decorator
require_once __DIR__ . '/../observers/Observer.php'; // Interface base do Observer

// 2. Classes de Domínio e Entidades
require_once __DIR__ . '/../domain/Participante.php';
require_once __DIR__ . '/../domain/Inscricao.php'; // Implementa Desconto (Componente Decorator)

// 3. Strategy
require_once __DIR__ . '/../strategies/PrecoStrategy.php'; // Interface Strategy
require_once __DIR__ . '/../strategies/AlunoStrategy.php'; 
require_once __DIR__ . '/../strategies/ProfissionalStrategy.php';

// 4. Decorator (Base deve vir antes dos Concretos)
require_once __DIR__ . '/../decorators/DescontoDecorator.php'; // Classe Abstrata Decorator
require_once __DIR__ . '/../decorators/CupomDesconto.php';
require_once __DIR__ . '/../decorators/IsencaoMonitor.php';

// 5. Observer
require_once __DIR__ . '/../observers/ConfirmacaoEmailObserver.php';
require_once __DIR__ . '/../observers/LogAlteracaoObserver.php';

// 6. Singleton
require_once __DIR__ . '/../infra/ConfigSingleton.php';


// --- USO DE NAMESPACES ---

use Domain\Participante;
use Domain\Inscricao;
use Strategies\AlunoStrategy;
use Strategies\ProfissionalStrategy;
use Decorators\CupomDesconto;
use Decorators\IsencaoMonitor;
use Observer\ConfirmacaoEmailObserver;
use Observer\LogAlteracaoObserver;
use Infra\ConfigSingleton;


// --- DADOS E EXECUÇÃO ---

$precoInicialLote = 250.00;
$participanteAluno = new Participante('Alice Silva', 'aluno');
$participanteProf = new Participante('Bob Santos', 'profissional');
$strategyAluno = new AlunoStrategy();
$strategyProf = new ProfissionalStrategy();


echo "=========================================================<br>";
echo "           DEMONSTRAÇÃO DE DESIGN PATTERNS (CLI)         <br>";
echo "=========================================================<br>";


// 1. Teste Strategy e Observer (Preço Base e Notificação)
echo "--- 1. STRATEGY (Cálculo Base: R$ 250,00) ---<br>";

// Instância 1: Aluno
$inscricaoAluno = new Inscricao($participanteAluno);
$inscricaoAluno->setPrecoStrategy($strategyAluno, $precoInicialLote); // Strategy: Aluno (20% off)

// Anexar Observers
$inscricaoAluno->attach(new ConfirmacaoEmailObserver());
$inscricaoAluno->attach(new LogAlteracaoObserver());

// Confirmar (Dispara Observers)
$inscricaoAluno->notify(); 

echo "    Perfil: ALUNO (Strategy)<br>";
echo "    Desconto Base: 20%<br>";
echo "    Preço Base Calculado: R$ " . number_format($inscricaoAluno->getPrecoBase(), 2, ',', '.') . "\n"; // R$ 200,00

echo "<br>--- Logs (Observer) ---<br>";


// 2. Teste Decorator (Composição de Descontos)
echo "<br>=========================================================<br>";
echo "--- 2. DECORATOR (Composição de Descontos) ---<br>";

// Instância 2: Profissional (Objeto base para a decoração)
$inscricaoProf = new Inscricao($participanteProf);
$inscricaoProf->setPrecoStrategy($strategyProf, $precoInicialLote); // Strategy: Profissional (10% off)
$precoProfBase = $inscricaoProf->getPrecoBase(); 
echo "    Preço Base Profissional (R$ 250,00 - 10%): R$ " . number_format($precoProfBase, 2, ',', '.') . "<br>";


// Decorator: Aplica descontos em camadas sobre o preço base.
$valorDecorado = $inscricaoProf; 

// 2a. Aplicar Cupom (95% do preço atual)
$valorDecorado = new CupomDesconto($valorDecorado); 

// 2b. Aplicar Isenção Total de Monitor (Decora o Cupom)
$valorDecorado = new IsencaoMonitor($valorDecorado); 

// Resultado final Decorado: Chamando a cadeia de cálculo.
$precoFinalDecorado = $valorDecorado->getValor($precoInicialLote); 

echo "    [Desconto 1] Cupom (5%)<br>";
echo "    [Desconto 2] Isenção Monitor (100%)<br>";
echo "    PREÇO FINAL PAGO: R$ " . number_format($precoFinalDecorado, 2, ',', '.') . "<br>"; // R$ 0.00


// 3. Teste Singleton (Unicidade da Configuração)
echo "<br>=========================================================<br>";
echo "--- 3. SINGLETON (Configuração Global) ---<br>";

$configA = ConfigSingleton::getInstance();
$configB = ConfigSingleton::getInstance();

echo "    Configuração Carregada: Lote " . $configA->getSetting('lote_atual') . "<br>";

// Teste de Unicidade
if ($configA === $configB) {
    echo "    Teste de Unicidade: SUCESSO! Instâncias A e B são o mesmo objeto.<br>";
} else {
    echo "    Teste de Unicidade: FALHA!<br>";
}

echo "\n=========================================================\n";
echo "<footer>Desenvolvido por: Melissa Minati</footer><br>";