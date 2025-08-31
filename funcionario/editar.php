<?php include '../db/conexao.php'; ?>

<?php
$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM funcionario WHERE id_funcionario = :id");
$query->execute(['id' => $id]);
$func = $query->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    $sql = "UPDATE funcionario SET nome=:nome, sobrenome=:sobrenome, cpf=:cpf, endereco=:endereco, telefone=:telefone, email=:email, agencia=:agencia, conta=:conta, pix=:pix, obs=:obs 
            WHERE id_funcionario=:id";
    $stmt = $pdo->prepare($sql);
    $_POST['id'] = $id;
    $stmt->execute($_POST);

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Editar Funcionário</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= $func['nome'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Sobrenome</label>
                <input type="text" name="sobrenome" class="form-control" value="<?= $func['sobrenome'] ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label>CPF</label>
            <input type="text" name="cpf" class="form-control" value="<?= $func['cpf'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Endereço</label>
            <input type="text" name="endereco" class="form-control" value="<?= $func['endereco'] ?>">
        </div>
        <div class="mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?= $func['telefone'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $func['email'] ?>">
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Agência</label>
                <input type="text" name="agencia" class="form-control" value="<?= $func['agencia'] ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label>Conta</label>
                <input type="text" name="conta" class="form-control" value="<?= $func['conta'] ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label>PIX</label>
                <input type="text" name="pix" class="form-control" value="<?= $func['pix'] ?>">
            </div>
        </div>
        <div class="mb-3">
            <label>Observações</label>
            <input type="text" name="obs" class="form-control" value="<?= $func['obs'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="listar.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

</body>
</html>
