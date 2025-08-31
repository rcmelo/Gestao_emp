<?php
// Configuração do banco: escolha "mysql" ou "pgsql"
$driver   = "mysql"; // troque para "mysql" se quiser MySQL
$host     = "localhost";
//$port     = "5432"; // PostgreSQL usa 5432, MySQL usa 3306
$port1    = "3306"; // PostgreSQL usa 5432, MySQL usa 3306
$dbname   = "restaurante";
$username = "root";
$password = "";

try {
    if ($driver === "mysql") {
        $dsn = "mysql:host=$host;port=$port1;dbname=$dbname;charset=utf8";
    } elseif ($driver === "pgsql") {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    } else {
        throw new Exception("Driver inválido! Use 'mysql' ou 'pgsql'.");
    }

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("❌ Erro na conexão: " . $e->getMessage());
}
?>
