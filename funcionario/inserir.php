<?php
require '../db/conexao.php';

if ($_POST) {
    $sql = "INSERT INTO funcionario 
        (nome, sobrenome, cpf, endereco, telefone, email, agencia, conta, pix, obs)
        VALUES (:nome, :sobrenome, :cpf, :endereco, :telefone, :email, :agencia, :conta, :pix, :obs)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome'      => $_POST['nome'],
        ':sobrenome' => $_POST['sobrenome'],
        ':cpf'       => $_POST['cpf'],
        ':endereco'  => $_POST['endereco'],
        ':telefone'  => $_POST['telefone'],
        ':email'     => $_POST['email'],
        ':agencia'   => $_POST['agencia'],
        ':conta'     => $_POST['conta'],
        ':pix'       => $_POST['pix'],
        ':obs'       => $_POST['obs'],
    ]);
    
    header("Location: listar.php?msg=funcionario+inserido+com+sucesso");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Inserir Funcionário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h2>? Cadastrar Funcionário</h2>
  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Sobrenome</label>
      <input type="text" name="sobrenome" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">CPF</label>
      <input type="text" name="cpf" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Endereço</label>
      <input type="text" name="endereco" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Telefone</label>
      <input type="text" name="telefone" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Agência</label>
      <input type="text" name="agencia" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Conta</label>
      <input type="text" name="conta" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Chave Pix</label>
      <input type="text" name="pix" class="form-control">
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
