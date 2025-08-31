<?php
require '../db/conexao.php';


if ($_POST) {
    $sql = "INSERT INTO fornecedor (nome, contato, cpf_cnpj, endereco, tipo, produto, obs)
            VALUES (:nome, :contato, :cpf_cnpj, :endereco, :tipo, :produto, :obs)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($_POST);
    header("Location: listar.php?msg=Fornecedor+inserido+com+sucesso");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Inserir Fornecedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h2>➕ Cadastrar Fornecedor</h2>
  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Contato</label>
      <input type="text" name="contato" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">cpf/cnpj</label>
      <input type="text" name="cpf_cnpj" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Endereco</label>
      <input type="text" name="endereco" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Tipo</label>
      <input type="text" name="tipo" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Produto</label>
      <input type="text" name="produto" class="form-control">
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

</body>
</html>
