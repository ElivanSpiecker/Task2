<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../classes/tarefa.php';

class TarefaTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "123", "task2");
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
        $dados = [
            'descricao' => 'Inexistente',
            'data_prevista' => date('Y-m-d'),
            'data_encerramento' => null,
            'situacao' => 'pendente'
        ];
        $this->assertFalse(Tarefa::editar($this->conn, -1, $dados));
    }

    public function testExcluirTarefaInexistente() {
        $this->assertFalse(Tarefa::excluir($this->conn, -999));
    }

    public function testCriarTarefaDescricaoVazia() {
        $dados = [
            'descricao' => '',
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        $this->assertFalse(Tarefa::criar($this->conn, $dados));
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
        $desc = str_repeat('A', 300);
        $dados = [
            'descricao' => $desc,
            'data_prevista' => date('Y-m-d'),
            'situacao' => 'pendente'
        ];
        $this->assertFalse(@Tarefa::criar($this->conn, $dados));
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
        $dados = [
            'descricao' => '',
            'data_prevista' => '',
            'data_encerramento' => '',
            'situacao' => ''
        ];
        $this->assertFalse(Tarefa::editar($this->conn, -1, $dados));
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
        $filtros = ['data_criacao' => '9999-99-99'];
        $result = Tarefa::listar($this->conn, $filtros);
        $this->assertIsObject($result);
    }

    public function testSituacaoInvalidaNoFiltro() {
        $filtros = ['situacao' => 'inválida'];
        $result = Tarefa::listar($this->conn, $filtros);
        $this->assertIsObject($result);
    }

    public function testCriarTarefaDataFormatoInvalido() {
        $dados = [
            'descricao' => 'Data inválida',
            'data_prevista' => '31-12-2025',
            'situacao' => 'pendente'
        ];
        $this->assertFalse(@Tarefa::criar($this->conn, $dados));
    }

    public function testCriarTarefaSemSituacao() {
        $dados = [
            'descricao' => 'Sem situação',
            'data_prevista' => date('Y-m-d')
        ];
        $this->assertFalse(@Tarefa::criar($this->conn, $dados));
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
