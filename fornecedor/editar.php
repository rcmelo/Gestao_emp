<?php
require '../db/conexao.php';

// Buscar fornecedor
if (isset($_GET['id'])) {
    $id_fornecedor = $_GET['id'];
    $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_fornecedor]);
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$fornecedor) {
        die("Fornecedor n�o encontrado.");
    }
}

// Atualizar fornecedor
if ($_POST) {
    $sql = "UPDATE fornecedor 
            SET nome=:nome, contato=:contato, cpf_cnpj=:cpf_cnpj, endereco=:endereco, 
                tipo=:tipo, produto=:produto, obs=:obs
            WHERE id_fornecedor = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id'],
        ':nome' => $_POST['nome'],
        ':contato' => $_POST['contato'],
        ':cpf_cnpj' => $_POST['cpf_cnpj'],
        ':endereco' => $_POST['endereco'],
        ':tipo' => $_POST['tipo'],
        ':produto' => $_POST['produto'],
        ':obs' => $_POST['obs']
    ]);
    header("Location: listar.php?msg=Fornecedor+atualizado+com+sucesso");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Fornecedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h2>✝ Editar Fornecedor</h2>
  <form method="POST" class="row g-3">
    <input type="hidden" name="id" value="<?= $fornecedor['id_fornecedor'] ?>">
    <div class="col-md-6">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" value="<?= $fornecedor['nome'] ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Contato</label>
      <input type="text" name="contato" class="form-control" value="<?= $fornecedor['contato'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">CPF/CNPJ</label>
      <input type="text" name="cpf_cnpj" class="form-control" value="<?= $fornecedor['cpf_cnpj'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Endereco</label>
      <input type="text" name="endereco" class="form-control" value="<?= $fornecedor['endereco'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Tipo</label>
      <input type="text" name="tipo" class="form-control" value="<?= $fornecedor['tipo'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Produto</label>
      <input type="text" name="produto" class="form-control" value="<?= $fornecedor['produto'] ?>">
    </div>
    <div class="col-12">
      <label class="form-label">Observação</label>
      <textarea name="obs" class="form-control"><?= $fornecedor['obs'] ?></textarea>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-warning">Atualizar</button>
      <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>

</body>
</html>
