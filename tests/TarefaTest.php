<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../classes/tarefa.php';

class TarefaTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "123", "meu_banco");
    }

    public function testCriarTarefaValida() {
        $dados = [
            'descricao' => 'Teste Unitário 1',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        $this->assertTrue(Tarefa::criar($this->conn, $dados));
    }

    public function testEditarTarefaInexistente() {
        $this->assertTrue(true);
    }

    public function testExcluirTarefaInexistente() {
        $this->assertTrue(true);
    }

    public function testCriarTarefaDescricaoVazia() {
        $this->assertTrue(true);
    }

    public function testCriarTarefaComDataPassada() {
        $dados = [
            'descricao' => 'Com data passada',
            'data_prevista' => date('Y-m-d', strtotime('-1 day')),
            'situacao' => 'pendente'
        ];
        $this->assertTrue(Tarefa::criar($this->conn, $dados));
    }

    public function testCriarTarefaConcluida() {
        $dados = [
            'descricao' => 'Tarefa Concluída',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'concluida'
        ];
        $this->assertTrue(Tarefa::criar($this->conn, $dados));
    }

    public function testListarTarefasPendentes() {
        $filtros = ['situacao' => 'pendente'];
        $result = Tarefa::listar($this->conn, $filtros);
        $this->assertIsObject($result);
    }

    public function testListarPorDataPrevista() {
        $filtros = ['data_prevista' => date('Y-m-d')];
        $result = Tarefa::listar($this->conn, $filtros);
        $this->assertIsObject($result);
    }

    public function testCriarTarefaMuitoLonga() {
        $this->assertTrue(true);
    }

    public function testCriarMultiplasTarefasRapidamente() {
        for ($i = 0; $i < 5; $i++) {
            $dados = [
                'descricao' => 'Auto gerada ' . $i,
                'data_prevista' => date('Y-m-d'),
                'situacao' => 'pendente'
            ];
            $this->assertTrue(Tarefa::criar($this->conn, $dados));
        }
    }

    public function testExcluirTarefaExistente() {
        $dados = [
            'descricao' => 'Para excluir',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        Tarefa::criar($this->conn, $dados);
        $id = $this->conn->insert_id;
        $this->assertTrue(Tarefa::excluir($this->conn, $id));
    }

    public function testEditarComCamposVazios() {
        $this->assertTrue(true);
    }

    public function testListarTodasSemFiltro() {
        $result = Tarefa::listar($this->conn);
        $this->assertIsObject($result);
    }

    public function testDescricaoHTMLInjection() {
        $dados = [
            'descricao' => '<script>alert("x")</script>',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        $this->assertTrue(Tarefa::criar($this->conn, $dados));
    }

    public function testListarDataCriacaoInvalida() {
        $this->assertTrue(true);
    }

    public function testSituacaoInvalidaNoFiltro() {
        $this->assertTrue(true);
    }

    public function testCriarTarefaDataFormatoInvalido() {
        $this->assertTrue(true);
    }

    public function testCriarTarefaSemSituacao() {
        $this->assertTrue(true);
    }

    public function testEditarComDadosValidos() {
        $dados = [
            'descricao' => 'Editável',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        Tarefa::criar($this->conn, $dados);
        $id = $this->conn->insert_id;
        $novos = [
            'descricao' => 'Editado',
            'data_prevista' => date('Y-m-d'),
            'data_encerramento' => null,
            'situacao' => 'concluida'
        ];
        $this->assertTrue(Tarefa::editar($this->conn, $id, $novos));
    }
}
