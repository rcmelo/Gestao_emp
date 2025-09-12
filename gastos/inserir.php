<?php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $valor_gasto = $_POST['valor_gasto'];
    $dt_gasto = $_POST['dt_gasto'];
    $gasto = $_POST['gasto'];
    $obs = $_POST['obs'];
    

    try {
        $sql = "INSERT INTO outros_gastos (tipo, valor_gasto, dt_gasto, gasto, obs)
                VALUES (:tipo, :valor_gasto, :dt_gasto, :gasto, :obs)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tipo'=>$tipo, ':gasto'=>$gasto, ':valor_gasto'=>$valor_gasto,
            ':dt_gasto'=>$dt_gasto, ':obs'=>$obs
        ]);
        header("Location: listar.php");
        exit;
    } catch (Exception $e) {
        echo "Erro: ".$e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Novo Gasto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
<h2>Novo Gasto</h2>
<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select">
            <option value="">-- Selecione o Tipo --</option>
            <option value="Pessoal">Pessoal</option>
            <option value="Empresarial">Empresarial</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Gasto</label>
        <select name="gasto" class="form-select">
            <option value="">-- Selecione o Gasto --</option>
            <option value="Mercado">Mercado</option>
            <option value="Aluguel">Aluguel</option>
            <option value="Combustivel">Combustível</option>
            <option value="Lazer">Lazer</option>
            <option value="Alimentacao">Alimentação</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Valor</label>
        <input type="number" step="0.01" name="valor_gasto" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Data</label>
        <input type="date" name="dt_gasto" class="form-control" required>
    </div>
    
    <div class="col-12">
        <label class="form-label">Observação</label>
        <textarea name="obs" class="form-control"></textarea>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
</div>
</body>
</html>
