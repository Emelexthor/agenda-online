<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Corrigido para usar $password

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'eventos');

    // Verificar se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Prevenção contra SQL Injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);

    // Query para inserção de dados
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    // Executar a consulta e verificar se foi bem-sucedida
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: login.php');
        exit;
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styleregis.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Cadastro</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Digite seu nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>
            <div class="mt-3 text-center">
                <a href="login.php" class="text-decoration-none">Já tem uma conta? Faça login</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>