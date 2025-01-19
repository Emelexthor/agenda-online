<?php
$conn = new mysqli('localhost', 'root', '', 'eventos');

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Mensagem de feedback
$mensagem = "";

// Processar atualização de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $novo_status = $_POST['status'];

    $sql_update = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $novo_status, $id);

    if ($stmt_update->execute()) {
        $mensagem = "Status atualizado com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar o status: " . $stmt_update->error;
    }
    $stmt_update->close();
}

// Configuração da paginação 
$limite_por_pagina = 10; // Quantidade de registros por página
$num_pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1; // Número da página
$inicio = ($num_pagina - 1) * $limite_por_pagina; // Registro inicial

// Variável para armazenar o filtro de data
$filtro_data = isset($_GET['data']) ? $_GET['data'] : '';

// Montar consulta para obter o total de registros com ou sem filtro
if (!empty($filtro_data)) {
    $total_registros_sql = "SELECT COUNT(*) as total 
                            FROM appointments a 
                            JOIN users u ON a.user_id = u.id 
                            WHERE a.date = ?";
    $stmt = $conn->prepare($total_registros_sql);
    $stmt->bind_param('s', $filtro_data);
    $stmt->execute();
    $result_total = $stmt->get_result();
} else {
    $total_registros_sql = "SELECT COUNT(*) as total FROM appointments a JOIN users u ON a.user_id = u.id";
    $result_total = $conn->query($total_registros_sql);
}

$total_registros = $result_total->fetch_assoc()['total'];

// Montar consulta principal com ou sem filtro e paginação
if (!empty($filtro_data)) {
    $sql = "SELECT a.id, u.name, a.date, a.time, a.status, a.tipo, a.NumPessoas, a.orgaoServentia, a.descricao, a.atendimento 
            FROM appointments a 
            JOIN users u ON a.user_id = u.id 
            WHERE a.date = ? 
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $filtro_data, $inicio, $limite_por_pagina);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT a.id, u.name, a.date, a.time, a.status, a.tipo, a.NumPessoas, a.orgaoServentia, a.descricao, a.atendimento 
            FROM appointments a 
            JOIN users u ON a.user_id = u.id
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $inicio, $limite_por_pagina);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Páginação - Links para as páginas
$total_paginas = ceil($total_registros / $limite_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php include 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciar Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styleAdm.css">
</head>



<body class="container py-5">

    <h2 class="text-center mb-4">Gerenciar Agendamentos</h2>

    <!-- Mensagem de feedback -->
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <!-- Formulário de pesquisa por data -->
    <form method="GET" action="" class="d-flex justify-content-center mb-4 gap-3">
        <div class="input-group">
            <label for="data" class="input-group-text">Pesquisar por Data</label>
            <input type="date" name="data" id="data" class="form-control" value="<?= htmlspecialchars($filtro_data) ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-custom">Pesquisar</button>
        <a href="admin.php" class="btn btn-secondary btn-custom">Limpar Filtro</a>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered text-dark">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Tipo</th>
                    <th>Nº Pessoas</th>
                    <th>Orgão / Serventia</th>
                    <th>Descrição</th>
                    <th>Atendimento</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):
                    $data_formatada = (new DateTime($row['date']))->format('d/m/Y');
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($data_formatada) ?></td>
                        <td><?= htmlspecialchars($row['time']) ?></td>
                        <td><?= htmlspecialchars($row['tipo']) ?></td>
                        <td><?= htmlspecialchars($row['NumPessoas']) ?></td>
                        <td><?= htmlspecialchars($row['orgaoServentia']) ?></td>
                        <td><?= htmlspecialchars($row['descricao']) ?></td>
                        <td><?= htmlspecialchars($row['atendimento']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select">
                                    <option value="Pendente" <?= $row['status'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                    <option value="Confirmado" <?= $row['status'] == 'Confirmado' ? 'selected' : '' ?>>Confirmado</option>
                                    <option value="NaoAutorizado" <?= $row['status'] == 'NaoAutorizado' ? 'selected' : '' ?>>Não Autorizado</option>
                                    <option value="Cancelado" <?= $row['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                                <button type="submit" class="btn btn-warning mt-2">Atualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= $num_pagina == $i ? 'active' : '' ?>">
                    <a class="page-link" href="admin.php?pagina=<?= $i ?>&data=<?= htmlspecialchars($filtro_data) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <?php include 'footer.php'; ?>

    <!-- Incluindo o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>