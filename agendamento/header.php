<head>
    <meta charset="UTF-8">
    <title>Minha Empresa - Página Inicial</title>
    <!-- Incluindo o Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styleAdm.css">
</head>

<!-- index.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-info ">
    <div class="container">
        <!-- Links à esquerda (Minha Empresa) -->
        <a class="navbar-brand text-dark" href="#">Assessoria de Catering Institucional (ASCAT)</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Links à esquerda -->
            <ul class="navbar-nav">
                <?php
                // Verificar o tipo de usuário logado
                if (isset($_SESSION['user_role'])) {
                    // Exibir os links apenas para o admin ou user
                    if ($_SESSION['user_role'] == 'admin') {
                        echo '<li class="nav-item ms-3"><a class="btn btn-primary nav-link text-white" href="admin.php">Admin</a></li>';
                    } elseif ($_SESSION['user_role'] == 'user') {
                        echo '<li class="nav-item"><a class="btn btn-primary nav-link text-white" href="agendamento.php">Agenda</a></li>';
                    }
                }
                ?>
            </ul>

            <!-- Links à direita -->
            <ul class="navbar-nav ms-auto"> <!-- Alinha os links à direita -->
                <li class="nav-item">
                    <a class="nav-link text-dark" href="index.php">Início</a>
                </li>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class=" nav-link text-dark" href="register.php">Cadastrar</a>
                    </li>
                    <li class="nav-item">
                        <a class=" nav-link text-dark" href="login.php">Login</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class=" nav-link text-dark" href="#">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class=" nav-link text-dark" href="logout.php">Sair</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>