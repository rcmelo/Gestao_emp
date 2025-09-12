<?php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_outgas'])) {
    $id_outgas = $_POST['id_outgas'];

    // Se for atualização (quando os campos do form são enviados)
    if (isset($_POST['tipo'], $_POST['valor_gasto'], $_POST['dt_gasto'], $_POST['gasto'])) {
        try {
            $sql = "UPDATE outros_gastos 
                    SET tipo = :tipo, valor_gasto = :valor, dt_gasto = :dt, 
                        gasto = :gasto, obs = :obs
                    WHERE id_outgas = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':tipo' => $_POST['tipo'],
                ':valor' => $_POST['valor_gasto'],
                ':dt' => $_POST['dt_gasto'],
                ':gasto' => $_POST['gasto'],
                ':obs' => $_POST['obs'],
                ':id' => $id_outgas
            ]);

            header("Location: listar.php?msg=atualizado");
            exit;
        } catch (Exception $e) {
            header("Location: listar.php?msg=erro");
            exit;
        }
    }

    // Se ainda não foi enviado o form ? carrega os dados
    $sql = "SELECT * FROM outros_gastos WHERE id_outgas = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_outgas]);
    $gasto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gasto) {
        header("Location: listar.php?msg=naoencontrado");
        exit;
    }
} else {
    header("Location: listar.php?msg=invalid");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Gasto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4">Editar Gasto</h2>
        <form method="POST" class="row g-3"
            onsubmit="return confirm('Tem certeza que deseja salvar as alterações deste gasto?');">
            <input type="hidden" name="id_outgas" value="<?= $gasto['id_outgas'] ?>">

            <div class="col-md-6">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="">-- Selecione o Tipo --</option>
                    <option value="Pessoal" <?= $gasto['tipo'] == 'Pessoal' ? 'selected' : '' ?>>Pessoal</option>
                    <option value="Empresarial" <?= $gasto['tipo'] == 'Empresarial' ? 'selected' : '' ?>>Empresarial</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Valor</label>
                <input type="number" step="0.01" name="valor_gasto" class="form-control"
                    value="<?= $gasto['valor_gasto'] ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Data</label>
                <input type="date" name="dt_gasto" class="form-control"
                    value="<?= $gasto['dt_gasto'] ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Gasto</label>
                <select name="gasto" class="form-select" required>
                    <option value="">-- Selecione o Gasto --</option>
                    <option value="Mercado" <?= $gasto['gasto'] == 'Mercado' ? 'selected' : '' ?>>Mercado</option>
                    <option value="Aluguel" <?= $gasto['gasto'] == 'Aluguel' ? 'selected' : '' ?>>Aluguel</option>
                    <option value="Combustivel" <?= $gasto['gasto'] == 'Combustivel' ? 'selected' : '' ?>>Combustível</option>
                    <option value="Lazer" <?= $gasto['gasto'] == 'Lazer' ? 'selected' : '' ?>>Lazer</option>
                    <option value="Alimentacao" <?= $gasto['gasto'] == 'Alimentacao' ? 'selected' : '' ?>>Alimentação</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Descrição</label>
                <textarea name="obs" class="form-control"><?= htmlspecialchars($gasto['obs']) ?></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Atualizar</button>
                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</body>

</html>