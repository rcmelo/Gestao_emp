<?php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = $_POST['id_pedido'] ?? null;
} else {
    die('Pedido não informado.');
}

// Buscar pedido
$sql = "SELECT * FROM pedidos WHERE id_pedido = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_pedido]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) die('Pedido não encontrado.');

// Buscar fornecedores
$fornecedores = $pdo->query("SELECT id_fornecedor, nome FROM fornecedor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Atualizar pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto'])) {
    $produto = $_POST['produto'];
    $valor = $_POST['valor'];
    $quantidade = $_POST['quantidade'];
    $data_pedido = $_POST['data_pedido'];
    $data_ent = $_POST['data_ent'];
    $data_pag = !empty($_POST['data_pag']) ? $_POST['data_pag'] : null;
    $status = $_POST['status'];
    $id_fornecedor = $_POST['id_fornecedor'];

    try {
        $sqlUpdate = "UPDATE pedidos SET 
                        produto=:produto, valor=:valor, quantidade=:quantidade, 
                        data_pedido=:data_pedido, data_ent=:data_ent, data_pag=:data_pag, 
                        status=:status, id_fornecedor=:id_fornecedor
                      WHERE id_pedido=:id_pedido";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':produto'=>$produto, ':valor'=>$valor, ':quantidade'=>$quantidade,
            ':data_pedido'=>$data_pedido, ':data_ent'=>$data_ent, ':data_pag'=>$data_pag,
            ':status'=>$status, ':id_fornecedor'=>$id_fornecedor, ':id_pedido'=>$id_pedido
        ]);
        echo '<div class="alert alert-success">Pedido atualizado com sucesso! <a href="listar.php" class="alert-link">Voltar</a></div>';
        $pedido = array_merge($pedido, $_POST);
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Erro: '.$e->getMessage().'</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Pedido</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<h2 class="mb-4">Editar Pedido</h2>

<form method="POST" class="row g-3" onsubmit="return confirm('Tem certeza que deseja salvar as alterações deste pedido?');">
    <input type="hidden" name="id_pedido" value="<?= $pedido['id_pedido'] ?>">
    
    <div class="col-md-6">
        <label class="form-label">Produto</label>
        <input type="text" name="produto" class="form-control" value="<?= htmlspecialchars($pedido['produto']) ?>" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Valor</label>
        <input type="number" step="0.01" name="valor" class="form-control" value="<?= $pedido['valor'] ?>" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Quantidade</label>
        <input type="number" name="quantidade" min="1" class="form-control" value="<?= $pedido['quantidade'] ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Data Pedido</label>
        <input type="date" name="data_pedido" class="form-control" value="<?= $pedido['data_pedido'] ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Data Entrega</label>
        <input type="date" name="data_ent" class="form-control" value="<?= $pedido['data_ent'] ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Data Pagamento</label>
        <input type="date" name="data_pag" class="form-control" value="<?= $pedido['data_pag'] ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" <?= $pedido['status'] == 1 ? 'selected' : '' ?>>Pago</option>
            <option value="0" <?= $pedido['status'] == 0 ? 'selected' : '' ?>>Em aberto</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Fornecedor</label>
        <select name="id_fornecedor" class="form-select" required>
            <option value="">-- Selecione o fornecedor --</option>
            <?php foreach ($fornecedores as $f): ?>
                <option value="<?= $f['id_fornecedor'] ?>" <?= $pedido['id_fornecedor']==$f['id_fornecedor']?'selected':'' ?>>
                    <?= htmlspecialchars($f['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
