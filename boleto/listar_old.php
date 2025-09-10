<?php include '../db/conexao.php'; ?>
<?php $pagina = 'boleto'; ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Boletos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <a href="../principal.php" class="btn btn-dark mb-3">Principal</a>
  <a href="inserir.php" class="btn btn-success mb-3">Novo Boleto</a>

  <div class="table-responsive">
    <table id="tabelaBoleto" class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nº Boleto</th>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Valor</th>
          <th>Vencimento</th>
          <th>Valor Pago</th>
          <th>Pagamento</th>
          <th>Status</th>
          <th>Fornecedor</th>
          <th>Observações</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = $pdo->query("SELECT b.*, f.nome AS fornecedor 
                              FROM boleto_pag b 
                              JOIN fornecedor f ON b.id_fornecedor = f.id_fornecedor");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($res as $i => $row) { ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><?= $row['n_boleto'] ?></td>
            <td><?= $row['produto'] ?></td>
            <td><?= $row['quantidade'] ?></td>
            <td>R$ <?= number_format($row['valor'],2,',','.') ?></td>
            <td><?= date("d/m/Y", strtotime($row['dt_vencimento'])) ?></td>
            <td>R$ <?= number_format($row['valor_pago'],2,',','.') ?></td>
            <td><?= $row['dt_pagamento'] ? date("d/m/Y", strtotime($row['dt_pagamento'])) : '-' ?></td>
            <td><?= $row['status'] == 1 ? 'Pago' : 'Em aberto' ?></td>
            <td><?= $row['fornecedor'] ?></td>
            <td><?= $row['obs'] ?></td>
            <td>
              <a href="editar.php?id=<?= $row['id_boleto'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="excluir.php?id=<?= $row['id_boleto'] ?>" 
                 onclick="return confirm('Tem certeza que deseja excluir este boleto?')" 
                 class="btn btn-sm btn-danger">Excluir</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function(){
  $('#tabelaBoleto').DataTable({
    "pageLength": 10,
    "lengthChange": false,
    "language": {
      "search": "Buscar:",
      "paginate": { "next": "Próximo", "previous": "Anterior" },
      "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
      "zeroRecords": "Nada encontrado"
    }
  });
});
</script>
</body>
</html>
