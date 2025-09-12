<?php
include '../db/conexao.php';
$outros = $pdo->query("SELECT * FROM outros_gastos ORDER BY dt_gasto DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Outros Gastos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<div class="container py-4 flex-grow-1">
    <h2 class="mb-4">Outros Gastos</h2>

    <a href="../principal.php" class="btn btn-dark mb-3">Principal</a>
    <a href="inserir.php" class="btn btn-success mb-3">+ Novo Gasto</a>

    <div class="table-responsive">
        <table id="tabelaGastos" class="table table-striped table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Gasto</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($outros as $g): ?>
                <tr>
                    <td><?= $g['id_outgas'] ?></td>
                    <td><?= htmlspecialchars($g['tipo']) ?></td>
                    <td>R$ <?= number_format($g['valor_gasto'],2,',','.') ?></td>
                    <td><?= $g['dt_gasto'] ?></td>
                    <td><?= htmlspecialchars($g['gasto']) ?></td>
                    <td><?= htmlspecialchars($g['obs']) ?></td>
                    <td>
                        <form method="POST" action="editar.php" class="d-inline">
                            <input type="hidden" name="id_outgas" value="<?= $g['id_outgas'] ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                        </form>
                        <form method="POST" action="excluir.php" class="d-inline" onsubmit="return confirm('Confirma a exclusão?');">
                            <input type="hidden" name="id_outgas" value="<?= $g['id_outgas'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
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

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    $('#tabelaGastos').DataTable({
        "pageLength": 10,
        "lengthChange": true,       // permite alterar qtd de linhas
        "searching": true,
        "ordering": true,
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "paginate": { "next": "Próximo", "previous": "Anterior" },
            "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Nenhum registro encontrado",
            "zeroRecords": "Nada encontrado"
        }
    });
});
</script>

</body>
</html>
