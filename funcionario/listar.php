<?php include '../db/conexao.php'; ?>
<?php $pagina = 'funcionario'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Fornecedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <a href="../principal.php" type="button" class="btn btn-dark mt-2 mb-4">Principal</a>
        <a href="inserir.php" type="button" class="btn btn-dark mt-2 mb-4">Novo Funcionario</a>

        <div class="table-responsive">
            <table id="tabelaFuncionario" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th> <!-- contador -->
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>CPF</th>
                        <th>Endere&ccedil;o</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Agencia</th>
                        <th>Conta</th>
                        <th>Pix</th>
                        <th>Observa&ccedil;&otilde;es</th>
                        <th>A&ccedil;&otilde;es</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT * FROM funcionario");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i = 0; $i < count($res); $i++) {
                        $id_reg = $res[$i]['id_funcionario'];
                    ?>
                        <tr>
                            <td><?= $i + 1; ?></td> <!-- contador -->
                            <td><?= $res[$i]['nome']; ?></td>
                            <td><?= $res[$i]['sobrenome']; ?></td>
                            <td><?= $res[$i]['cpf']; ?></td>
                            <td><?= $res[$i]['endereco']; ?></td>
                            <td><?= $res[$i]['telefone']; ?></td>
                            <td><?= $res[$i]['email']; ?></td>
                            <td><?= $res[$i]['agencia']; ?></td>
                            <td><?= $res[$i]['conta']; ?></td>
                            <td><?= $res[$i]['pix']; ?></td>
                            <td><?= $res[$i]['obs']; ?></td>
                            <td>
                                <a href="editar.php?id=<?= $res[$i]['id_funcionario']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <i class="bi bi-pencil-square"></i>
                                </a>

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
                                                Tem certeza que deseja excluir <b><?= $res[$i]['nome']; ?> <?= $res[$i]['sobrenome']; ?></b>?
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
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap + DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inicialização -->
    <script>
        $(document).ready(function() {
            $('#tabelaFuncionario').DataTable({
                "pageLength": 10, // mostra 10 registros por página
                "lengthChange": false, // esconde opção de alterar qtd de registros
                "ordering": true, // permite ordenar colunas
                "language": {
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Pr&oacute;ximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando _START_ at&eacute; _END_ de _TOTAL_ registros",
                    "infoEmpty": "Nenhum registro encontrado",
                    "zeroRecords": "Nada encontrado",
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>