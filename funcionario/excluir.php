<?php
require '../db/conexao.php';

// Verifica se veio o ID pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // força ser número inteiro

    try {
        // Prepara o DELETE
        $sql = "DELETE FROM funcionario WHERE id_funcionario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redireciona de volta para listar.php com mensagem
            header("Location: listar.php?msg=Funcionario+excluido+com+sucesso");
            exit;
        } else {
            header("Location: listar.php?msg=Erro+ao+excluir");
            exit;
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Caso tentem acessar sem ID válido
    header("Location: listar.php?msg=ID+invalido");
    exit;
}
