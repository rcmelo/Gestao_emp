<?php include '../db/conexao.php'; ?>
<?php $pagina = 'boleto_pag'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Boletos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <a href="../principal.php" class="btn btn-dark mt-2 mb-4">Principal</a>
        <a href="inserir.php" class="btn btn-success mt-2 mb-4">Novo Boleto</a>

        <!-- Alertas -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['msg']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="tabelaBoleto" class="table table-striped table-hover table-striped table-bordered table-sm my-4">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>N&#0176; Boleto</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Valor Pago</th>
                        <th>Data Pagamento</th>
                        <th>Status</th>
                        <th>Observa&ccedil;&otilde;es</th>
                        <th>Fornecedor</th>
                        <th>A&ccedil;&otilde;es</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("
                SELECT b.id_boleto, b.n_boleto, b.produto, b.quantidade, b.valor, 
                       b.dt_vencimento, b.valor_pago, b.dt_pagamento, b.status, b.obs,
                       f.nome AS fornecedor_nome
                FROM boleto_pag b
                INNER JOIN fornecedor f ON b.id_fornecedor = f.id_fornecedor
                ORDER BY b.id_boleto DESC
            ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($res as $i => $row): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $row['n_boleto'] ?></td>
                            <td><?= $row['produto'] ?></td>
                            <td><?= $row['quantidade'] ?></td>
                            <td>R$<?= number_format($row['valor'], 2, ',', '.') ?></td>
                            <td><?= date('d/m/Y', strtotime($row['dt_vencimento'])) ?></td>
                            <td>R$<?= number_format($row['valor_pago'], 2, ',', '.') ?></td>
                            <td><?= $row['dt_pagamento'] ? date('d/m/Y', strtotime($row['dt_pagamento'])) : '-' ?></td>
                            <td>
                                <?php
                                if ($res[$i]['status'] == 1) {
                                    echo '<span class="badge bg-success">Pago</span>';
                                } else {
                                    echo '<span class="badge bg-warning">Em aberto</span>';
                                }
                                ?>
                            </td>
                            <td><?= $row['obs'] ?></td>
                            <td><?= $row['fornecedor_nome'] ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="editar.php?id=<?= $row['id_boleto'] ?>"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <a href="excluir.php?id=<?= $row['id_boleto'] ?>"
                                        onclick="return confirm('Tem certeza que deseja excluir este boleto?');"
                                        class="btn btn-sm btn-danger">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap + DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabelaBoleto').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "ordering": true,
                "language": {
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                    "infoEmpty": "Nenhum registro encontrado",
                    "zeroRecords": "Nada encontrado",
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>