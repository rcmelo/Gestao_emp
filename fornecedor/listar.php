<?php include '../db/conexao.php'; ?>
<?php $pagina = 'fornecedor'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Fornecedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">

  <div class="container mt-5 mb-5"> <!-- margem inferior adicionada -->

    <a href="../principal.php" type="button" class="btn btn-dark mt-2 mb-3">Principal</a>
    <a href="inserir.php" type="button" class="btn btn-success mt-2 mb-3">Novo Fornecedor</a>

    <div class="table-responsive">
      <table id="tabelaFornecedor" class="table table-striped table-hover table-bordered table-sm">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Contato</th>
            <th>CPF/CNPJ</th>
            <th>Endereço</th>
            <th>Tipo</th>
            <th>Produto</th>
            <th>Observações</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = $pdo->query("SELECT * FROM fornecedor");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          foreach ($res as $i => $row):
            $id_reg = $row['id_fornecedor'];
          ?>
            <tr>
              <td><?= $i + 1; ?></td>
              <td><?= htmlspecialchars($row['nome']); ?></td>
              <td><?= htmlspecialchars($row['contato']); ?></td>
              <td><?= htmlspecialchars($row['cpf_cnpj']); ?></td>
              <td><?= htmlspecialchars($row['endereco']); ?></td>
              <td><?= htmlspecialchars($row['tipo']); ?></td>
              <td><?= htmlspecialchars($row['produto']); ?></td>
              <td><?= htmlspecialchars($row['obs']); ?></td>
              <td>
                <div class="btn-group" role="group">
                  <a href="editar.php" class="btn btn-sm btn-primary">Editar</a>
                  <a href="excluir.php" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?');">Excluir</a>
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
      $('#tabelaFornecedor').DataTable({
        "pageLength": 10,      // registros por página padrão
        "lengthChange": true,  // permite alterar quantidade de linhas exibidas
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
