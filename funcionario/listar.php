<?php include '../db/conexao.php'; ?>
<?php $pagina = 'funcionario'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<div class="container mt-5 mb-5 flex-grow-1"> <!-- flex-grow-1 expande o conteúdo -->
    <a href="../principal.php" class="btn btn-dark mt-2 mb-3">Principal</a>
    <a href="inserir.php" class="btn btn-success mt-2 mb-3">Novo Funcionário</a>

    <div class="table-responsive">
        <table id="tabelaFuncionario" class="table table-striped table-hover table-bordered table-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Agência</th>
                <th>Conta</th>
                <th>Pix</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query = $pdo->query("SELECT * FROM funcionario");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($res as $i => $row):
                $id_reg = $row['id_funcionario'];
                ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= htmlspecialchars($row['nome']); ?></td>
                    <td><?= htmlspecialchars($row['sobrenome']); ?></td>
                    <td><?= htmlspecialchars($row['cpf']); ?></td>
                    <td><?= htmlspecialchars($row['endereco']); ?></td>
                    <td><?= htmlspecialchars($row['telefone']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['agencia']); ?></td>
                    <td><?= htmlspecialchars($row['conta']); ?></td>
                    <td><?= htmlspecialchars($row['pix']); ?></td>
                    <td><?= htmlspecialchars($row['obs']); ?></td>
                    <td>
                        <a href="editar.php?id=<?= $id_reg ?>" class="btn btn-sm btn-primary me-1">Editar</a>

                        <!-- Botão Excluir que abre modal -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmaExclusao<?= $id_reg ?>">
                            Excluir
                        </button>

                        <!-- Modal Bootstrap -->
                        <div class="modal fade" id="confirmaExclusao<?= $id_reg ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir <b><?= htmlspecialchars($row['nome'] . ' ' . $row['sobrenome']); ?></b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <a href="excluir.php?id=<?= $id_reg ?>" class="btn btn-danger">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Rodapé -->
<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y') ?> Sistema de Gestão - Todos os direitos reservados
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelaFuncionario').DataTable({
        "pageLength": 10,      
        "lengthChange": true,  
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
