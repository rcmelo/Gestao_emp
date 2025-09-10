<?php
include 'db/conexao.php';

// Totais atuais
$totais_boletos = $pdo->query("
    SELECT SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) AS pago, 
           SUM(CASE WHEN status=0 THEN 1 ELSE 0 END) AS nao_pago 
    FROM boleto_pag
")->fetch(PDO::FETCH_ASSOC);

$totais_pedidos = $pdo->query("
    SELECT SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) AS pago, 
           SUM(CASE WHEN status=0 THEN 1 ELSE 0 END) AS nao_pago 
    FROM pedidos
")->fetch(PDO::FETCH_ASSOC);

// Dados últimos 7 dias para mini-gr&aacute;ficos
$dados_boletos_dia = $pdo->query("
    SELECT DATE(dt_vencimento) as dia, 
           SUM(CASE WHEN status=0 THEN 1 ELSE 0 END) as nao_pago, 
           SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) as pago
    FROM boleto_pag
    WHERE dt_vencimento >= CURDATE() - INTERVAL 6 DAY
    GROUP BY DATE(dt_vencimento)
    ORDER BY DATE(dt_vencimento)
")->fetchAll(PDO::FETCH_ASSOC);

$dados_pedidos_dia = $pdo->query("
    SELECT DATE(data_pedido) as dia, 
           SUM(CASE WHEN status=0 THEN 1 ELSE 0 END) as nao_pago, 
           SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) as pago
    FROM pedidos
    WHERE data_pedido >= CURDATE() - INTERVAL 6 DAY
    GROUP BY DATE(data_pedido)
    ORDER BY DATE(data_pedido)
")->fetchAll(PDO::FETCH_ASSOC);

$cor_boletos = ($totais_boletos['nao_pago'] > 0) ? 'danger pulse' : 'success';
$cor_pedidos = ($totais_pedidos['nao_pago'] > 0) ? 'danger pulse' : 'success';
$cor_comissao = 'secondary';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema de Gest&atilde;o</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background: #343232d7;
            color: #fff;
            padding-top: 1rem;
        }

        .sidebar a,
        .sidebar button.accordion-button {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.3rem 0.8rem;
            border-radius: 5px;
            margin: 0.1rem 0;
            white-space: nowrap;
            font-size: 0.9rem;
        }

        .sidebar a:hover,
        .sidebar button.accordion-button:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar h4 {
            font-size: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .content {
            margin-left: 240px;
            padding: 1rem;
        }

        @media (max-width:768px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse {
            animation: pulse 1.5s infinite;
        }

        .card-mini-chart {
            height: 40px;
        }

        .card-small h5 {
            font-size: 0.9rem;
        }

        .card-small h2 {
            font-size: 1.5rem;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Sidebar desktop -->
    <div class="sidebar d-none d-md-block">
        <h4>Menu</h4>
        <div class="accordion" id="sidebarAccordion">

            <!-- Funcion&aacute;rios -->
            <div class="accordion-item bg-transparent border-0">
                <h2 class="accordion-header" id="headingFunc">
                    <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFunc" aria-expanded="false">
                        <i class="bi bi-people me-2"></i> Funcion&aacute;rios
                    </button>
                </h2>
                <div id="collapseFunc" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body p-0">
                        <a href="funcionario/listar.php">Listar Funcion&aacute;rios</a>
                        <a href="funcionario/inserir.php">Novo Funcion&aacute;rio</a>
                        <a href="salario_comissao/listar.php">Pagamentos</a>
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

    <!-- Navbar topo mobile -->
    <nav class="navbar bg-primary navbar-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                <i class="bi bi-list"></i> Menu
            </button>
            <span class="navbar-brand mb-0 h1">Sistema de Gest&atilde;o</span>
        </div>
    </nav>

    <!-- Offcanvas mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="accordion" id="offcanvasAccordion">
                <!-- Repetir links do menu -->
                <a href="funcionario/listar.php" class="d-block p-2">Listar Funcion&aacute;rios</a>
                <a href="fornecedor/listar.php" class="d-block p-2">Listar Fornecedores</a>
                <a href="pedido/listar.php" class="d-block p-2">Listar Pedidos</a>
                <a href="boleto/listar.php" class="d-block p-2">Listar Boletos</a>
            </div>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="content">

        <!-- Boas-vindas -->
        <div class="bg-white shadow rounded p-3 mb-4">
            <h3 class="mb-2">Bem-vindo ao Sistema de Gest&atilde;o</h3>
            <p>Use este painel para monitorar boletos, pedidos, fornecedores e funcion&aacute;rios.</p>
        </div>

        <!-- Cards com mini-gr&aacute;ficos -->
        <div class="row mb-3">

            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_boletos ?>">
                    <div class="card-body">
                        <h5>Boletos n&atilde;o pagos</h5>
                        <h2><?= $totais_boletos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_pedidos ?>">
                    <div class="card-body">
                        <h5>Pedidos n&atilde;o pagos</h5>
                        <h2><?= $totais_pedidos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_comissao ?>">
                    <div class="card-body">
                        <h5>Comissao</h5>
                        <h2><?= $totais_pedidos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_pedidos ?>">
                    <div class="card-body">
                        <h5>Pedidos n&atilde;o pagos</h5>
                        <h2><?= $totais_pedidos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_pedidos ?>">
                    <div class="card-body">
                        <h5>Pedidos n&atilde;o pagos</h5>
                        <h2><?= $totais_pedidos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="card card-small border-0 shadow-sm text-white bg-<?= $cor_pedidos ?>">
                    <div class="card-body">
                        <h5>Pedidos n&atilde;o pagos</h5>
                        <h2><?= $totais_pedidos['nao_pago'] ?></h2>
                        <canvas id="miniChartPedidos" class="card-mini-chart mt-1"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- Gr&aacute;fico comparativo -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="mb-2">Comparativo Pagos x N&atilde;o Pagos</h5>
                    <canvas id="chartComparativo" style="height:200px;"></canvas>
                </div>
            </div>
        </div>

    </div>

    <script>
        const ctxMain = document.getElementById('chartComparativo').getContext('2d');
        new Chart(ctxMain, {
            type: 'bar',
            data: {
                labels: ['Boletos', 'Pedidos'],
                datasets: [{
                        label: 'Pago',
                        data: [<?= $totais_boletos['pago'] ?>, <?= $totais_pedidos['pago'] ?>],
                        backgroundColor: '#198754'
                    },
                    {
                        label: 'Nao pago',
                        data: [<?= $totais_boletos['nao_pago'] ?>, <?= $totais_pedidos['nao_pago'] ?>],
                        backgroundColor: '#dc3545'
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        function gerarMiniChart(id, dados) {
            const ctx = document.getElementById(id).getContext('2d');
            const labels = dados.map(d => d.dia);
            const pagos = dados.map(d => parseInt(d.pago));
            const abertos = dados.map(d => parseInt(d.nao_pago));
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pago (1)',
                            data: pagos,
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25,135,84,0.2)',
                            tension: 0.3
                        },
                        {
                            label: 'N&atilde;o pago (0)',
                            data: abertos,
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220,53,69,0.2)',
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });
        }

        gerarMiniChart('miniChartBoletos', <?= json_encode($dados_boletos_dia) ?>);
        gerarMiniChart('miniChartPedidos', <?= json_encode($dados_pedidos_dia) ?>);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>