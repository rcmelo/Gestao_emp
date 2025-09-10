<?php 
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sal_com'])) {
    $id_sal_com = $_POST['id_sal_com'];

    try {
        $sql = "DELETE FROM salario_comissao WHERE id_sal_com = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_sal_com]);

        header("Location: listar.php?msg=excluido");
        exit;
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Erro ao excluir: ' . $e->getMessage() . '</div>';
    }
} else {
    header("Location: listar.php");
    exit;
}
?>
