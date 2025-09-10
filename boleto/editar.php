<?php include '../db/conexao.php'; ?>

<?php
// Pega o ID do boleto pela URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: listar.php?msg=Boleto+não+encontrado");
    exit;
}

// Se o formulário foi enviado
if ($_POST) {
    $sql = "UPDATE boleto_pag 
            SET n_boleto = :n_boleto, produto = :produto, quantidade = :quantidade, valor = :valor, 
                dt_vencimento = :dt_vencimento, valor_pago = :valor_pago, dt_pagamento = :dt_pagamento, 
                status = :status, obs = :obs, id_fornecedor = :id_fornecedor
            WHERE id_boleto = :id";
    $stmt = $pdo->prepare($sql);
    $_POST['id'] = $id;
    $stmt->execute($_POST);
    header("Location: listar.php?msg=Boleto+atualizado+com+sucesso");
    exit;
}

// Busca os dados do boleto
$stmt = $pdo->prepare("SELECT * FROM boleto_pag WHERE id_boleto = ?");
$stmt->execute([$id]);
$boleto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$boleto) {
    header("Location: listar.php?msg=Boleto+não+existe");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Boleto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2>?? Editar Boleto</h2>
<form method="POST" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Número Boleto</label>
    <input type="text" name="n_boleto" value="<?= $boleto['n_boleto'] ?>" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Produto</label>
    <input type="text" name="produto" value="<?= $boleto['produto'] ?>" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Quantidade</label>
    <input type="number" name="quantidade" value="<?= $boleto['quantidade'] ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Valor</label>
    <input type="number" step="0.01" name="valor" value="<?= $boleto['valor'] ?>" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Vencimento</label>
    <input type="date" name="dt_vencimento" value="<?= $boleto['dt_vencimento'] ?>" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Valor Pago</label>
    <input type="number" step="0.01" name="valor_pago" value="<?= $boleto['valor_pago'] ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Data Pagamento</label>
    <input type="date" name="dt_pagamento" value="<?= $boleto['dt_pagamento'] ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="0" <?= $boleto['status']==0 ? 'selected' : '' ?>>Em aberto</option>
      <option value="1" <?= $boleto['status']==1 ? 'selected' : '' ?>>Pago</option>
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Fornecedor</label>
    <select name="id_fornecedor" class="form-select" required>
      <?php
      $forn = $pdo->query("SELECT id_fornecedor, nome FROM fornecedor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
      foreach($forn as $f){
        $sel = $f['id_fornecedor'] == $boleto['id_fornecedor'] ? 'selected' : '';
        echo "<option value='{$f['id_fornecedor']}' $sel>{$f['nome']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="col-12">
    <label class="form-label">Observações</label>
    <textarea name="obs" class="form-control"><?= $boleto['obs'] ?></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Salvar Alterações</button>
    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

</body>
</html>
