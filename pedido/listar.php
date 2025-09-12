<?php 
include '../db/conexao.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<div class="container mt-5 mb-5 flex-grow-1">
    <h2 class="mb-4">Pedidos</h2>

    <a href="../principal.php" class="btn btn-dark mb-3">Principal</a>
    <a href="inserir.php" class="btn btn-success mb-3">Novo Pedido</a>

    <div class="table-responsive">
        <table id="tabelaPedido" class="table table-hover table-striped table-bordered table-sm">
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
                    <th>Ações</th>
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

                foreach ($res as $row):
                    $status = $row['status'] == 1 
                              ? '<span class="badge bg-success">Pago</span>' 
                              : '<span class="badge bg-warning">Em aberto</span>';
                ?>
                    <tr>
                        <td><?= $row['id_pedido'] ?></td>
                        <td><?= htmlspecialchars($row['produto']) ?></td>
                        <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                        <td><?= $row['quantidade'] ?></td>
                        <td><?= $row['data_pedido'] ?></td>
                        <td><?= $row['data_ent'] ?></td>
                        <td><?= $row['data_pag'] ?></td>
                        <td><?= $status ?></td>
                        <td><?= htmlspecialchars($row['fornecedor_nome']) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Editar via POST -->
                                <form method="POST" action="editar.php" style="display:inline;">
                                    <input type="hidden" name="id_pedido" value="<?= $row['id_pedido'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                                </form>

                                <!-- Excluir via POST com confirmação -->
                                <form method="POST" action="excluir.php" style="display:inline;" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
                                    <input type="hidden" name="id_pedido" value="<?= $row['id_pedido'] ?>">
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

<!-- Rodapé -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    &copy; <?= date('Y') ?> Sistema de Gestão - Todos os direitos reservados
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelaPedido').DataTable({
        "pageLength": 10,      // registros por página padrão
        "lengthChange": true,  // permite alterar quantidade de linhas exibidas
        "searching": true,
        "ordering": true,
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior"
            },
            "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Nenhum registro encontrado",
            "zeroRecords": "Nada encontrado"
        }
    });
});
</script>

</body>
</html>
