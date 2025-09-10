<?php
require '../db/conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM boleto_pag WHERE id_boleto = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: listar.php?msg=Boleto+excluído+com+sucesso");
        exit;
    } catch (PDOException $e) {
        // Se houver erro no banco
        header("Location: listar.php?msg=Erro+ao+excluir:+".urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: listar.php?msg=ID+inválido");
    exit;
}
