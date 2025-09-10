<?php
include '../db/conexao.php';

// Buscar funcionários para o select
$stmt = $pdo->query("SELECT id_funcionario, nome FROM funcionario ORDER BY nome");
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
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

    $sql = "INSERT INTO salario_comissao 
        (valor_salario_pago, dt_pagamento, valor_com_pago, dt_ref_ini, dt_ref_fin, status, obs, sal_com, id_funcionario)
        VALUES (:valor_salario_pago, :dt_pagamento, :valor_com_pago, :dt_ref_ini, :dt_ref_fin, :status, :obs, :sal_com, :id_funcionario)";
    
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
    <title>Inserir Salário/Comissão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Novo Salário/Comissão</h2>
    <form method="POST" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Funcionário</label>
            <select name="id_funcionario" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($funcionarios as $f): ?>
                    <option value="<?= $f['id_funcionario'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Salário Pago</label>
            <input type="number" step="0.01" name="valor_salario_pago" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Pagamento</label>
            <input type="date" name="dt_pagamento" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Valor Pago</label>
            <input type="number" step="0.01" name="valor_com_pago" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Início Ref.</label>
            <input type="date" name="dt_ref_ini" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Data Fim Ref.</label>
            <input type="date" name="dt_ref_fin" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1">Pago</option>
                <option value="0">Pendente</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Tipo Pagamento</label>
            <select name="obs" class="form-select">
                <option value="DIARIA">Diária</option>
                <option value="ADIANTAMENTO">Adiantamento</option>
                <option value="SALARIO">Salário</option>
                <option value="COMISSAO">Comissão</option>
                <option value="AUSENTE">Ausente</option>
                <option value="FOLGA">Folga</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
