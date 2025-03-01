<?php
// Função para validar e sanitizar entradas
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}
?>
