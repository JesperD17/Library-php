<?php

if (php_sapi_name() !== 'cli' && PHP_SAPI !== 'cli' && !defined('STDIN')) {
    fwrite(STDERR, "This script must be run from the command line.\n");
    exit(1);
}

include __DIR__ . '/../actions/includes/dbConnection.php';
include 'migrate.functions.php';

$files = glob(__DIR__ . '/../database/migrations/*.sql');
if ($files === false) {
    fwrite(STDERR, "Failed to read migration files.\n");
    exit(1);
}

$db->exec(migrationsTable());

$prevMigrations = $db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN, 0);
$files = array_filter($files, function ($file) use ($prevMigrations) {
    return !in_array(basename($file), $prevMigrations);
});

foreach ($files as $file) {
    $sql = file_get_contents($file);
    if ($sql === false) {
        fwrite(STDERR, "Failed to read file: $file\n");
        continue;
    }

    try {
        $db->exec($sql);
        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute([':migration' => basename($file)]);
        echo "Successfully executed migration: " . basename($file) . "\n";
    } catch (PDOException $e) {
        fwrite(STDERR, "Error executing migration " . basename($file) . ": " . $e->getMessage() . "\n");
    }
}