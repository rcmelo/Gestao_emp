<?php include 'db/conexao.php'; ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Pedidos e Fornecedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">Sistema de Gest&atilde;o</h1>

    <!-- Botão principal que abre o menu -->
    <p>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-expanded="false" aria-controls="menu">
            Menu
        </button>
    </p>

    <!-- Collapse do Menu -->
    <div class="collapse" id="menu">
        <div class="card card-body">
            <div class="accordion" id="accordionMenu">

               <!-- Grupo Funcionarios -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFuncionarios">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFuncionarios" aria-expanded="false" aria-controls="collapseFornecedores">
                             Funcionarios
                        </button>
                    </h2>
                    <div id="collapseFuncionarios" class="accordion-collapse collapse" aria-labelledby="headingFuncionarios" data-bs-parent="#accordionMenu">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="fornecedor/listar.php">Listar Funcionarios</a></li>
                                <li class="list-group-item"><a href="fornecedor/inserir.php">Novo Funcionario</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Grupo Fornecedores -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFornecedores">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFornecedores" aria-expanded="false" aria-controls="collapseFornecedores">
                             Fornecedores
                        </button>
                    </h2>
                    <div id="collapseFornecedores" class="accordion-collapse collapse" aria-labelledby="headingFornecedores" data-bs-parent="#accordionMenu">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="fornecedor/listar.php">Listar Fornecedores</a></li>
                                <li class="list-group-item"><a href="fornecedor/inserir.php">Novo Fornecedor</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Grupo Pedidos -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPedidos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedidos" aria-expanded="false" aria-controls="collapsePedidos">
                             Pedidos
                        </button>
                    </h2>
                    <div id="collapsePedidos" class="accordion-collapse collapse" aria-labelledby="headingPedidos" data-bs-parent="#accordionMenu">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="pedido/listar.php">Listar Pedidos</a></li>
                                <li class="list-group-item"><a href="pedido/inserir.php">Novo Pedido</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Conteúdo inicial -->
    <div class="mt-4 p-4 bg-white shadow rounded">
        <h4>Bem-vindo!</h4>
        <p>Use o menu acima para navegar entre pedidos e fornecedores.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
