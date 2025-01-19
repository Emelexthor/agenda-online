<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'eventos');

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Evitar SQL Injection
    $email = $conn->real_escape_string($email);

    // Consulta ao banco de dados
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar a senha
        if (password_verify($password, $user['password'])) {
            // Segurança adicional
            session_regenerate_id();

            // Definir os dados da sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Verificar o papel do usuário
            if ($user['is_admin'] == 1) {
                $_SESSION['user_role'] = 'admin';
            } else {
                $_SESSION['user_role'] = 'user';
            }

            // Redirecionar com base no tipo de usuário
            if ($user['is_admin'] == 1) {
                header('Location: admin.php'); // Página de admin
            } else {
                header('Location: agendamento.php'); // Página de usuário comum
            }
            exit;
        } else {
            echo "Senha inválida.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include 'header.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/stylelog.css">
</head>

<body>

    
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        <div class="mt-3 text-center">
                            <a href="register.php" class="text-decoration-none">Cadaste-se Aqui</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>