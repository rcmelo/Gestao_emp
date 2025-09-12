<?php
// editar.php
include '../db/conexao.php';

// --- Apenas em desenvolvimento: mostrar erros (remover em produção) ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Mensagem de erro para exibir no formulário
$erro = null;

// ===== PROCESSAR SALVAR (quando o formulário é submetido) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    // pegar e validar id
    $id_pedido = isset($_POST['id_pedido']) ? (int) $_POST['id_pedido'] : 0;
    if ($id_pedido <= 0) {
        $erro = "ID do pedido inválido.";
    } else {
        // coletar campos (valide/escape conforme necessário)
        $produto = trim($_POST['produto'] ?? '');
        $valor = $_POST['valor'] ?? null;
        $quantidade = $_POST['quantidade'] ?? null;
        $data_pedido = $_POST['data_pedido'] ?? null;
        $data_ent = $_POST['data_ent'] ?? null;
        $data_pag = !empty($_POST['data_pag']) ? $_POST['data_pag'] : null;
        $status = isset($_POST['status']) ? (int) $_POST['status'] : 0;
        $id_fornecedor = isset($_POST['id_fornecedor']) ? (int) $_POST['id_fornecedor'] : null;

        try {
            $sqlUpdate = "UPDATE pedidos SET 
                            produto = :produto,
                            valor = :valor,
                            quantidade = :quantidade,
                            data_pedido = :data_pedido,
                            data_ent = :data_ent,
                            data_pag = :data_pag,
                            status = :status,
                            id_fornecedor = :id_fornecedor
                          WHERE id_pedido = :id_pedido";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':produto' => $produto,
                ':valor' => $valor,
                ':quantidade' => $quantidade,
                ':data_pedido' => $data_pedido,
                ':data_ent' => $data_ent,
                ':data_pag' => $data_pag,
                ':status' => $status,
                ':id_fornecedor' => $id_fornecedor,
                ':id_pedido' => $id_pedido
            ]);

            // Redireciona para a lista com mensagem de sucesso
            header("Location: listar.php?msg=atualizado");
            exit;
        } catch (PDOException $e) {
            // Em dev, mostrar erro detalhado; em produção, logue e mostre mensagem genérica
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}

// ===== CARREGAR DADOS PARA EXIBIR O FORMULÁRIO =====
// Aceitar id vindo via POST (form do listar) ou GET (link direto)
$id_pedido = null;
if (isset($_POST['id_pedido']) && !isset($_POST['salvar'])) {
    $id_pedido = (int) $_POST['id_pedido'];
} elseif (isset($_GET['id'])) {
    $id_pedido = (int) $_GET['id'];
}

// Se não tiver id, redireciona para listar
if (empty($id_pedido)) {
    header("Location: listar.php");
    exit;
}

// Buscar pedido
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id_pedido = :id");
$stmt->execute([':id' => $id_pedido]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    // registro não encontrado
    header("Location: listar.php?msg=naoencontrado");
    exit;
}

// Buscar fornecedores para o select
$fornecedores = $pdo->query("SELECT id_fornecedor, nome FROM fornecedor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
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

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3" onsubmit="return confirm('Tem certeza que deseja salvar as alterações deste pedido?');">
        <input type="hidden" name="id_pedido" value="<?= (int)$pedido['id_pedido'] ?>">
        <input type="hidden" name="salvar" value="1">

        <div class="col-md-6">
            <label class="form-label">Produto</label>
            <input type="text" name="produto" class="form-control" value="<?= htmlspecialchars($pedido['produto']) ?>" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Valor</label>
            <input type="number" step="0.01" name="valor" class="form-control" value="<?= htmlspecialchars($pedido['valor']) ?>" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade" min="1" class="form-control" value="<?= htmlspecialchars($pedido['quantidade']) ?>" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Data Pedido</label>
            <input type="date" name="data_pedido" class="form-control" value="<?= htmlspecialchars($pedido['data_pedido']) ?>" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Data Entrega</label>
            <input type="date" name="data_ent" class="form-control" value="<?= htmlspecialchars($pedido['data_ent']) ?>" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Data Pagamento</label>
            <input type="date" name="data_pag" class="form-control" value="<?= htmlspecialchars($pedido['data_pag']) ?>">
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
                    <option value="<?= $f['id_fornecedor'] ?>" <?= $pedido['id_fornecedor'] == $f['id_fornecedor'] ? 'selected' : '' ?>>
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
