<?php include '../db/conexao.php'; ?>
<?php $pagina = 'fornecedor'; ?>

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
    <a href="inserir.php" type="button" class="btn btn-dark mt-2 mb-4">Novo Fornecedor</a>

    <div class="table-responsive">
      <table id="tabelaFornecedor" class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th> <!-- contador -->
            <th>Nome</th>
            <th>Contato</th>
            <th>CPF/CNPJ</th>
            <th>Endereço</th>
            <th>Tipo</th>
            <th>Produto</th>
            <th>Observa&ccedil;&otilde;es</th>
            <th>A&ccedil;&otilde;es</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = $pdo->query("SELECT * FROM fornecedor");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          for ($i = 0; $i < count($res); $i++) {
            $id_reg = $res[$i]['id_fornecedor'];
          ?>
            <tr>
              <td><?= $i + 1; ?></td> <!-- contador -->
              <td><?= $res[$i]['nome']; ?></td>
              <td><?= $res[$i]['contato']; ?></td>
              <td><?= $res[$i]['cpf_cnpj']; ?></td>
              <td><?= $res[$i]['endereco']; ?></td>
              <td><?= $res[$i]['tipo']; ?></td>
              <td><?= $res[$i]['produto']; ?></td>
              <td><?= $res[$i]['obs']; ?></td>
              <td>
                <a href="index.php?pag=<?= $pagina; ?>&funcao=editar&id=<?= $id_reg; ?>" class="text-primary me-2">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="index.php?pag=<?= $pagina; ?>&funcao=excluir&id=<?= $id_reg; ?>" class="text-danger">
                  <i class="bi bi-trash"></i>
                </a>
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
      $('#tabelaFornecedor').DataTable({
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
