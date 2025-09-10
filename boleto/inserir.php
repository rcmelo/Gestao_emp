<?php include '../db/conexao.php'; ?>

<?php
if ($_POST) {
  $sql = "INSERT INTO boleto_pag 
          (n_boleto, produto, quantidade, valor, dt_vencimento, valor_pago, dt_pagamento, status, obs, id_fornecedor)
          VALUES (:n_boleto, :produto, :quantidade, :valor, :dt_vencimento, :valor_pago, :dt_pagamento, :status, :obs, :id_fornecedor)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute($_POST);
  header("Location: listar.php?msg=Boleto+inserido+com+sucesso");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Novo Boleto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2>? Novo Boleto</h2>
<form method="POST" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Número Boleto</label>
    <input type="text" name="n_boleto" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Produto</label>
    <input type="text" name="produto" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Quantidade</label>
    <input type="number" name="quantidade" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Valor</label>
    <input type="number" step="0.01" name="valor" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Vencimento</label>
    <input type="date" name="dt_vencimento" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Valor Pago</label>
    <input type="number" step="0.01" name="valor_pago" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Data Pagamento</label>
    <input type="date" name="dt_pagamento" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="0">Em aberto</option>
      <option value="1">Pago</option>
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Fornecedor</label>
    <select name="id_fornecedor" class="form-select" required>
      <?php
      $forn = $pdo->query("SELECT id_fornecedor, nome FROM fornecedor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
      foreach($forn as $f){
        echo "<option value='{$f['id_fornecedor']}'>{$f['nome']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="col-12">
    <label class="form-label">Observações</label>
    <textarea name="obs" class="form-control"></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

</body>
</html>
