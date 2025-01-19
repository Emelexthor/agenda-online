<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se o método do formulário é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formatando a data
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time = $_POST['time'];
    $tipo = $_POST['tipo'];
    $NumPessoas = $_POST['NumPessoas'];
    $orgaoServentia = $_POST['orgaoServentia'];
    $descricao = $_POST['descricao'];
    $atendimento = $_POST['atendimento'];
    $user_id = $_SESSION['user_id'];

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'eventos');

    // Verificando se houve erro de conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Prevenindo injeção SQL e escapando os dados
    $date = $conn->real_escape_string($date);
    $time = $conn->real_escape_string($time);
    $tipo = $conn->real_escape_string($tipo);
    $NumPessoas = $conn->real_escape_string($NumPessoas);
    $orgaoServentia = $conn->real_escape_string($orgaoServentia);
    $descricao = $conn->real_escape_string($descricao);
    $atendimento = $conn->real_escape_string($atendimento);
    $user_id = $conn->real_escape_string($user_id);

    // Inserindo os dados na tabela 'appointments'
    $sql = "INSERT INTO appointments (user_id, date, time, tipo, NumPessoas, orgaoServentia, descricao, atendimento) 
            VALUES ('$user_id', '$date', '$time', '$tipo', '$NumPessoas', '$orgaoServentia', '$descricao', '$atendimento')";

    if ($conn->query($sql) === TRUE) {
        echo "Aguardando a autorização!";
    } else {
        echo "Erro: " . $conn->error;
    }

    // Fechar a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styleagend.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <a class="btn btn-primary mb-3" href="meus_agendamentos.php">Meus agendamentos</a>

        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="input-date" class="form-label">Data:</label>
                    <input type="date" id="input-date" name="date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="input-time" class="form-label">Hora:</label>
                    <input type="time" id="input-time" name="time" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="">Selecione Evento / Reunião</option>
                    <option value="Evento">Evento</option>
                    <option value="Reunião">Reunião</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="NumPessoas" class="form-label">Num Pessoas:</label>
                <input type="text" name="NumPessoas" id="NumPessoas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="orgaoServentia" class="form-label">Orgão / Serventia:</label>
                <input type="text" name="orgaoServentia" id="orgaoServentia" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="atendimento" class="form-label">Atendimento:</label>
                <select name="atendimento" id="atendimento" class="form-select" required>
                    <option value="">Selecione o atendimento</option>
                    <option value="Água e café">Água e café</option>
                    <option value="Água, café e biscoitos">Água, café e biscoitos</option>
                    <option value="Coffee-break">Coffee-break</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Agendar</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>