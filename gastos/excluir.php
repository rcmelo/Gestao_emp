<?php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_outgas'])) {
    $id_outgas = $_POST['id_outgas'];

    try {
        $sql = "DELETE FROM outros_gastos WHERE id_outgas = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_outgas]);

        // Redireciona de volta para listar com mensagem
        header("Location: listar.php?msg=excluido");
        exit;
    } catch (Exception $e) {
        header("Location: listar.php?msg=erro");
        exit;
    }
} else {
    header("Location: listar.php?msg=invalid");
    exit;
}
