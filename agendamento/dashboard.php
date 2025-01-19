<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'eventos');

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consultas para contagem de eventos e reuniões
$contagem_eventos_sql = "SELECT COUNT(*) AS total_eventos FROM appointments WHERE tipo = 'Evento'";
$contagem_reunioes_sql = "SELECT COUNT(*) AS total_reunioes FROM appointments WHERE tipo = 'Reunião'";

// Executar consultas
$result_eventos = $conn->query($contagem_eventos_sql);
$result_reunioes = $conn->query($contagem_reunioes_sql);

// Obter os resultados
$total_eventos = $result_eventos->fetch_assoc()['total_eventos'];
$total_reunioes = $result_reunioes->fetch_assoc()['total_reunioes'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Eventos e Reuniões</title>
    <!--<link rel="stylesheet" href="./css/styledash.css">-->
</head>
<body>

    <?php include 'header.php'; ?>
    
    <h2>Dashboard - Eventos e Reuniões</h2>

    <div class="dashboard">
        <div class="card">
            <h3>Total de Eventos</h3>
            <p><?= $total_eventos ?></p>
        </div>
        
        <div class="card">
            <h3>Total de Reuniões</h3>
            <p><?= $total_reunioes ?></p>
        </div>

        <!-- Link para visualizar todos os eventos e reuniões -->
        <a href="admin.php">Visualizar Todos</a>
    </div>

    <?php include 'footer.php'; ?>
    
</body>
</html>
