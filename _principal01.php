<?php include 'db/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Gest&atilde;o de Pedidos e Fornecedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      overflow-x: hidden;
    }

    /* Sidebar fixa desktop */
    .sidebar {
      min-height: 100vh;
      width: 220px;
      position: fixed;
      top: 0;
      left: 0;
      background: #343232d7;
      color: #fff;
      padding-top: 1rem;
      transition: width 0.3s;
    }

    .sidebar a,
    .sidebar button.accordion-button {
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      margin: 0.1rem 0;
      white-space: nowrap;
    }

    .sidebar a:hover,
    .sidebar button.accordion-button:hover {
      background: rgba(255, 255, 255, 0.15);
    }

    .sidebar h5 {
      font-size: 1rem;
      margin-top: 1rem;
      padding-left: 1rem;
      opacity: 0.8;
    }

    .content {
      margin-left: 240px;
      padding: 2rem;
      transition: margin-left 0.3s;
    }

    /* Sidebar mobile escondida */
    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .content {
        margin-left: 0;
      }
    }
  </style>
</head>

<body class="bg-light">

  <!-- Navbar topo mobile -->
  <nav class="navbar bg-primary navbar-dark d-md-none">
    <div class="container-fluid">
      <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
        <i class="bi bi-list"></i> Menu
      </button>
      <span class="navbar-brand mb-0 h1">Sistema de Gest&atilde;o</span>
    </div>
  </nav>

  <!-- Sidebar desktop -->
  <div class="sidebar d-none d-md-block">
    <h4 class="text-center mb-3">Menu</h4>

    <div class="accordion" id="sidebarAccordion">

      <!-- Funcionários -->
      <div class="accordion-item bg-transparent border-0">
        <h2 class="accordion-header" id="headingFunc">
          <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFunc" aria-expanded="false">
            <i class="bi bi-people me-2"></i> Funcion&aacute;rios
          </button>
        </h2>
        <div id="collapseFunc" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
          <div class="accordion-body p-0">
            <a href="funcionario/listar.php">Listar Funcion&aacute;rios</a>
            <a href="fornecedor/inserir.php">Novo Funcion&aacute;rio</a>
            <a href="pagamento/listar.php">Pagamentos</a>
          </div>
        </div>
      </div>

      <!-- Fornecedores -->
      <div class="accordion-item bg-transparent border-0">
        <h2 class="accordion-header" id="headingForn">
          <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForn" aria-expanded="false">
            <i class="bi bi-building me-2"></i> Fornecedores
          </button>
        </h2>
        <div id="collapseForn" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
          <div class="accordion-body p-0">
            <a href="fornecedor/listar.php">Listar Fornecedores</a>
            <a href="fornecedor/inserir.php">Novo Fornecedor</a>
          </div>
        </div>
      </div>

      <!-- Pedidos -->
      <div class="accordion-item bg-transparent border-0">
        <h2 class="accordion-header" id="headingPed">
          <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePed" aria-expanded="false">
            <i class="bi bi-receipt me-2"></i> Pedidos
          </button>
        </h2>
        <div id="collapsePed" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
          <div class="accordion-body p-0">
            <a href="pedido/listar.php">Listar Pedidos</a>
            <a href="pedido/inserir.php">Novo Pedido</a>
          </div>
        </div>
      </div>


      <!-- Boletos -->
      <div class="accordion-item bg-transparent border-0">
        <h2 class="accordion-header" id="headingBol">
          <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBol" aria-expanded="false">
            <i class="bi bi-clipboard2-check me-2"></i> Boletos
          </button>
        </h2>
        <div id="collapseBol" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
          <div class="accordion-body p-0">
            <a href="boleto/listar.php">Listar Boletos</a>
            <a href="boleto/inserir.php">Novo Boleto</a>
          </div>
        </div>
      </div>



    </div>
  </div>

  <!-- Offcanvas mobile -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
    <div class="offcanvas-header bg-primary text-white">
      <h5 class="offcanvas-title">?? Menu</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
      <div class="accordion" id="offcanvasAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFuncMobile">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFuncMobile" aria-expanded="false">
              ?? Funcionários
            </button>
          </h2>
          <div id="collapseFuncMobile" class="accordion-collapse collapse" data-bs-parent="#offcanvasAccordion">
            <div class="accordion-body p-0">
              <a href="fornecedor/listar.php" class="d-block p-2">Listar Funcion&aacute;rios</a>
              <a href="fornecedor/inserir.php" class="d-block p-2">Novo Funcion&aacute;rio</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFornMobile">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFornMobile" aria-expanded="false">
              ?? Fornecedores
            </button>
          </h2>
          <div id="collapseFornMobile" class="accordion-collapse collapse" data-bs-parent="#offcanvasAccordion">
            <div class="accordion-body p-0">
              <a href="fornecedor/listar.php" class="d-block p-2">Listar Fornecedores</a>
              <a href="fornecedor/inserir.php" class="d-block p-2">Novo Fornecedor</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingPedMobile">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedMobile" aria-expanded="false">
              ?? Pedidos
            </button>
          </h2>
          <div id="collapsePedMobile" class="accordion-collapse collapse" data-bs-parent="#offcanvasAccordion">
            <div class="accordion-body p-0">
              <a href="pedido/listar.php" class="d-block p-2">Listar Pedidos</a>
              <a href="pedido/inserir.php" class="d-block p-2">Novo Pedido</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Conteúdo principal -->
  <div class="content">
    <div class="bg-white shadow rounded p-4">
      <h1 class="mb-4">Sistema de Gest&atilde;o</h1>
      <h4>Bem-vindo!</h4>
      <p>Use o menu lateral para navegar entre funcion&aacute;rios, fornecedores e pedidos.</p>
      <?php
      // ---- Consultas ----

      // Boletos não pagos
      $sql_boletos = "SELECT COUNT(*) AS total_boletos FROM boleto_pag WHERE status <> 'Pago'";
      $res_boletos = $conn->query($sql_boletos);
      $dados_boletos = $res_boletos->fetch_assoc();

      // Pedidos não pagos
      $sql_pedidos = "SELECT COUNT(*) AS total_pedidos FROM pedido WHERE status <> 'Pago'";
      $res_pedidos = $conn->query($sql_pedidos);
      $dados_pedidos = $res_pedidos->fetch_assoc();
      ?>

      <!-- Conteúdo principal -->
      <div class="content">
        <div class="bg-white shadow rounded p-4">
          <h1 class="mb-4">?? Dashboard</h1>
          <div class="row">

            <!-- Card Boletos -->
            <div class="col-md-6 mb-3">
              <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <i class="bi bi-clipboard2-check text-primary display-6 me-3"></i>
                  <div>
                    <h5 class="card-title mb-1">Boletos em aberto</h5>
                    <h2 class="mb-0"><?= $dados_boletos['total_boletos'] ?></h2>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Pedidos -->
            <div class="col-md-6 mb-3">
              <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <i class="bi bi-receipt text-danger display-6 me-3"></i>
                  <div>
                    <h5 class="card-title mb-1">Pedidos não pagos</h5>
                    <h2 class="mb-0"><?= $dados_pedidos['total_pedidos'] ?></h2>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>