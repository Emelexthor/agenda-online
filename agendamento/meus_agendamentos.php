<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli('localhost', 'root', '', 'eventos');

// Configurações de paginação
$records_per_page = 10; // Quantidade de registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Filtragem por data
$search_date = isset($_GET['search_date']) ? $_GET['search_date'] : '';
$where_clause = !empty($search_date) ? " AND DATE_FORMAT(date,'%Y-%m-%d') = '$search_date'" : '';
$sql = "SELECT DATE_FORMAT(date,'%d/%m/%Y') as format_date, time, tipo, NumPessoas, orgaoServentia, descricao, atendimento, status, notification 
        FROM appointments 
        WHERE user_id = '$user_id' $where_clause 
        LIMIT $records_per_page OFFSET $offset";
$result = $conn->query($sql);

// Contar o total de registros
$total_records_query = "SELECT COUNT(*) as total FROM appointments WHERE user_id = '$user_id' $where_clause";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];

$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleMeus.css">

    <script>
        function clearDateFilter() {
            document.getElementById('search_date').value = '';
            document.forms[0].submit(); // Submete o formulário após limpar o campo de data
        }
    </script>
</head>

<body>
    <!-- Cabeçalho -->
    <?php include 'header.php'; ?>

    <!--<header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Gestão de Agendamentos</h1>
            <nav>
                <a href="agendamento.php" class="btn btn-light btn-sm">Agendar</a>
                <a href="meus_agendamentos.php" class="btn btn-light btn-sm">Meus Agendamentos</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Sair</a>
            </nav>
        </div>
    </header>-->

    <main class="container my-5">

        <h2 class="mb-4">Meus Agendamentos</h2>

        <!-- Formulário de busca por data -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-auto">
                <label for="search_date" class="form-label">Pesquisar por Data:</label>
                <input type="date" id="search_date" name="search_date"
                    class="form-control"
                    value="<?= isset($_GET['search_date']) ? htmlspecialchars($_GET['search_date']) : '' ?>">
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Pesquisar</button>
                <button type="button" class="btn btn-secondary" onclick="clearDateFilter()">Limpar</button>
                <a href="agendamento.php" class="btn btn-light btn-sm">Agendar</a>
            </div>
        </form>

        <!-- Tabela de agendamentos -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Tipo</th>
                        <th>Num Pessoas</th>
                        <th>Orgão / Serventia</th>
                        <th>Descrição</th>
                        <th>Atendimento</th>
                        <th>Status</th>
                        <!--<th>Notificação</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['format_date']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                            <td><?= htmlspecialchars($row['tipo']) ?></td>
                            <td><?= htmlspecialchars($row['NumPessoas']) ?></td>
                            <td><?= htmlspecialchars($row['orgaoServentia']) ?></td>
                            <td><?= htmlspecialchars($row['descricao']) ?></td>
                            <td><?= htmlspecialchars($row['atendimento']) ?></td>
                            //<td><?= htmlspecialchars($row['status']) ?></td>
                            <!--<td><?= htmlspecialchars($row['notification']) ?></td>-->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search_date=<?= htmlspecialchars($search_date) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>