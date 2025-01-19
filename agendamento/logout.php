<?php
session_start();
session_unset();  // Remove todas as variáveis da sessão
session_destroy();  // Destroi a sessão

header('Location: index.php');  // Redireciona para a página inicial após o logout
exit;
?>