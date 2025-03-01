<?php
require '../config.php';

// Função para criar um novo backup
function createBackup() {
    global $pdo;
    $backupDir = '../backups/';
    $filename = 'backup_' . date('Ymd_His') . '.sql';
    $filepath = $backupDir . $filename;

    $command = "mysqldump --user={$pdo->getAttribute(PDO::ATTR_USER)} --password={$pdo->getAttribute(PDO::ATTR_PASSWORD)} --host={$pdo->getAttribute(PDO::ATTR_HOST)} {$pdo->getAttribute(PDO::ATTR_DBNAME)} > $filepath";
    system($command);

    $stmt = $pdo->prepare("INSERT INTO backups (filename) VALUES (?)");
    $stmt->execute([$filename]);
}

// Função para obter todos os backups
function getBackups() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM backups");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para restaurar um backup
function restoreBackup($filename) {
    global $pdo;
    $backupDir = '../backups/';
    $filepath = $backupDir . $filename;

    $command = "mysql --user={$pdo->getAttribute(PDO::ATTR_USER)} --password={$pdo->getAttribute(PDO::ATTR_PASSWORD)} --host={$pdo->getAttribute(PDO::ATTR_HOST)} {$pdo->getAttribute(PDO::ATTR_DBNAME)} < $filepath";
    system($command);
}
?>
