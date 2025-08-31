<?php include '../db/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listar de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <a href="../principal.php" type="button" class="btn btn-dark mt-2 mb-4">Principal</a>
        <a href="inserir.php" type="button" class="btn btn-dark mt-2 mb-4">Novo Pedido</a>


        <div class="table-responsive">
            <table id="example" class="table table-hover table-striped table-bordered table-sm my-4">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Quantidade</th>
                        <th>Data Pedido</th>
                        <th>Data Entrega</th>
                        <th>Data Pagamento</th>
                        <th>Status</th>
                        <th>Fornecedor</th>
                        <th>Acoes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("
                SELECT p.*, f.nome AS fornecedor_nome
                FROM pedidos p
                INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor
            ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        $id_reg = $res[$i]['id_pedido'];
                    ?>
                        <tr>
                            <td><?= $res[$i]['id_pedido']; ?></td>
                            <td><?= $res[$i]['produto']; ?></td>
                            <td>R$ <?= number_format($res[$i]['valor'], 2, ',', '.'); ?></td>
                            <td><?= $res[$i]['quantidade']; ?></td>
                            <td><?= $res[$i]['data_pedido']; ?></td>
                            <td><?= $res[$i]['data_ent']; ?></td>
                            <td><?= $res[$i]['data_pag']; ?></td>
                            <td>
                                <?php
                                if ($res[$i]['status'] == 1) {
                                    echo '<span class="badge bg-success">Pago</span>';
                                } else {
                                    echo '<span class="badge bg-warning">Em aberto</span>';
                                }
                                ?>
                            </td>

                            <td><?= $res[$i]['fornecedor_nome']; ?></td>
                            <td>
                                <a href="editar.php?id=<?= $res[$i]['id_pedido']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="excluir.php" title="Excluir" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>