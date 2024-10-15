<?php
// create_db.php
try {
    $pdo = new PDO('sqlite:./database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS mods (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                -- author TEXT NOT NULL,
                expansion TEXT NOT NULL,
                type TEXT NOT NULL,
                age TEXT NOT NULL,
                gender TEXT NOT NULL,
                clothing_category TEXT NOT NULL,
                size INTEGER NOT NULL
            )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS modders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        creation_date NUMERIC,
    )";
    $pdo->exec($sql);

    echo "Database and table created successfully.";

    $sql = 'INSERT INTO mods (name, expansion, type, age, gender, clothing_category, size) VALUES ("nom2", "expansion2", "bottom", "teen", "female", "sleepwear", 2),("nom1", "expansion1", "top", "child", "female", "casual",1)';
    $pdo->exec($sql);

    $sql = 'INSERT INTO modders (name, creation_date) VALUES ("nom2", "2024/01/11"),("nom1", "2024/01/11")';
    $pdo->exec($sql);

    echo "Dataset inserted successfully.";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
