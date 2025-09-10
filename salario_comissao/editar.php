<?php
include '../db/conexao.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = (int) $_GET['id'];

// Buscar registro
$stmt = $pdo->prepare("SELECT * FROM salario_comissao WHERE id_sal_com = ?");
$stmt->execute([$id]);
$registro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registro) {
    header("Location: listar.php");
    exit;
}

// Buscar funcionários
$stmt = $pdo->query("SELECT id_funcionario, nome FROM funcionario ORDER BY nome");
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        ':id' => $id,
        ':valor_salario_pago' => $_POST['valor_salario_pago'] ?? null,
        ':dt_pagamento' => $_POST['dt_pagamento'] ?? null,
        ':valor_com_pago' => $_POST['valor_com_pago'],
        ':dt_ref_ini' => $_POST['dt_ref_ini'] ?? null,
        ':dt_ref_fin' => $_POST['dt_ref_fin'] ?? null,
        ':status' => $_POST['status'],
        ':obs' => $_POST['obs'] ?? null,
        ':sal_com' => $_POST['sal_com'] ?? null,
        ':id_funcionario' => $_POST['id_funcionario']
    ];

    $sql = "UPDATE salario_comissao SET 
                valor_salario_pago=:valor_salario_pago,
                dt_pagamento=:dt_pagamento,
                valor_com_pago=:valor_com_pago,
                dt_ref_ini=:dt_ref_ini,
                dt_ref_fin=:dt_ref_fin,
                status=:status,
                obs=:obs,
                sal_com=:sal_com,
                id_funcionario=:id_funcionario
            WHERE id_sal_com=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($dados);

    header("Location: listar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Salário/Comissão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Editar Registro</h2>
    <form method="POST" class="row g-3" onsubmit="return confirm('Tem certeza que deseja salvar as alterações?');">

        <div class="col-md-6">
            <label class="form-label">Funcionário</label>
            <select name="id_funcionario" class="form-select" required>
                <?php foreach ($funcionarios as $f): ?>
                    <option value="<?= $f['id_funcionario'] ?>" <?= $f['id_funcionario']==$registro['id_funcionario']?'selected':'' ?>>
                        <?= htmlspecialchars($f['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Salário Pago</label>
            <input type="number" step="0.01" name="valor_salario_pago" value="<?= $registro['valor_salario_pago'] ?>" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Pagamento</label>
            <input type="date" name="dt_pagamento" value="<?= $registro['dt_pagamento'] ?>" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Comissão Paga *</label>
            <input type="number" step="0.01" name="valor_com_pago" value="<?= $registro['valor_com_pago'] ?>" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Início Ref.</label>
            <input type="date" name="dt_ref_ini" value="<?= $registro['dt_ref_ini'] ?>" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Fim Ref.</label>
            <input type="date" name="dt_ref_fin" value="<?= $registro['dt_ref_fin'] ?>" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" <?= $registro['status']==1?'selected':'' ?>>Pago</option>
                <option value="0" <?= $registro['status']==0?'selected':'' ?>>Pendente</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Descrição</label>
            <input type="text" name="sal_com" value="<?= $registro['sal_com'] ?>" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Observações</label>
            <input type="text" name="obs" value="<?= $registro['obs'] ?>" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
