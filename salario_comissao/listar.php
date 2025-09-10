<?php
include '../db/conexao.php';

// Buscar registros
$query = $pdo->query("
    SELECT sc.*, f.nome AS funcionario_nome
    FROM salario_comissao sc
    INNER JOIN funcionario f ON sc.id_funcionario = f.id_funcionario
    ORDER BY sc.dt_ref_fin DESC
");
$registros = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Salários e Comissões</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Salários e Comissões</h2>
    <a href="../principal.php" class="btn btn-dark mb-3">Principal</a>
    <a href="inserir.php" class="btn btn-success mb-3">Novo Registro</a>

    <div class="table-responsive">
        <table id="tabelaSalCom" class="table table-striped table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Funcionário</th>
                    <th>Salário Pago</th>
                    <th>Data Pagamento</th>
                    <th>Comissão Paga</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th>Tipo Pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($registros as $row): ?>
                <tr>
                    <td><?= $row['id_sal_com'] ?></td>
                    <td><?= htmlspecialchars($row['funcionario_nome']) ?></td>
                    <td>R$ <?= number_format($row['valor_salario_pago'],2,',','.') ?></td>
                    <td><?= $row['dt_pagamento'] ?></td>
                    <td>R$ <?= number_format($row['valor_com_pago'],2,',','.') ?></td>
                    <td><?= $row['dt_ref_ini'] ?> a <?= $row['dt_ref_fin'] ?></td>
                    <td>
                        <?php if($row['status']==1): ?>
                            <span class="badge bg-success">Pago</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Pendente</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['obs']) ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="editar.php?id=<?= $row['id_sal_com'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <form method="POST" action="excluir.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                                <input type="hidden" name="id_sal_com" value="<?= $row['id_sal_com'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#tabelaSalCom').DataTable({
        "pageLength": 10,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "paginate": {"next": "Próximo", "previous": "Anterior"},
            "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Nenhum registro encontrado",
            "zeroRecords": "Nada encontrado"
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
