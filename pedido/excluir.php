<?php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'])) {
    $id_pedido = (int) $_POST['id_pedido'];

    try {
        $sql = "DELETE FROM pedidos WHERE id_pedido = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_pedido]);
    } catch (Exception $e) {
        // Opcional: registrar erro em log
    }
}

// Redireciona para a lista de pedidos após exclusão
header('Location: listar.php');
exit;
