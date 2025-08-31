<?php
require '../db/conexao.php';

if (isset($_GET['id'])) {
    $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['id']]);
    header("Location: listar.php?msg=Fornecedor+excluido+com+sucesso");
    exit;
} else {
    echo "ID inválido.";
}
?>
