<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../classes/usuario.php';

class UsuarioTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "123", "task2");
    }

    public function testCadastrarUsuarioValido() {
        $nome = 'Usuário Teste';
        $email = 'usuario'.rand(1000,9999).'@teste.com';
        $senha = '123456';
        $this->assertTrue(Usuario::cadastrar($this->conn, $nome, $email, $senha));
    }

    public function testCadastrarUsuarioComEmailRepetido() {
        $nome = 'Usuário Duplicado';
        $email = 'duplicado@teste.com';
        $senha = '123456';

        // Inserir o primeiro
        Usuario::cadastrar($this->conn, $nome, $email, $senha);

        // Segundo deve falhar
        $this->assertFalse(Usuario::cadastrar($this->conn, $nome, $email, $senha));
    }

    public function testLoginComDadosCorretos() {
        $nome = 'Login OK';
        $email = 'loginok@teste.com';
        $senha = 'senha123';
        Usuario::cadastrar($this->conn, $nome, $email, $senha);

        $this->assertTrue(Usuario::login($this->conn, $email, $senha));
    }

    public function testLoginComSenhaIncorreta() {
        $nome = 'Login Ruim';
        $email = 'loginruim@teste.com';
        $senha = 'correta';
        Usuario::cadastrar($this->conn, $nome, $email, $senha);

        $this->assertFalse(Usuario::login($this->conn, $email, 'errada'));
    }

    public function testLoginEmailInexistente() {
        $this->assertFalse(Usuario::login($this->conn, 'naoexiste@teste.com', 'qualquer'));
    }

    public function testCadastrarUsuarioSemNome() {
        $this->assertFalse(Usuario::cadastrar($this->conn, '', 'semnome@teste.com', '1234'));
    }

    public function testCadastrarUsuarioSemSenha() {
        $this->assertFalse(Usuario::cadastrar($this->conn, 'Sem Senha', 'semsenha@teste.com', ''));
    }

    public function testCadastrarUsuarioSemEmail() {
        $this->assertFalse(Usuario::cadastrar($this->conn, 'Sem Email', '', '1234'));
    }
}
