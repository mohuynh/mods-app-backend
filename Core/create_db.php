<?php
// create_db.php
try {
    $pdo = new PDO('sqlite:./database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS modders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        mdp TEXT NOT NULL,
        creation_date NUMERIC NOT NULL
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS mods (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                expansion TEXT NOT NULL,
                type TEXT NOT NULL,
                age TEXT NOT NULL,
                gender TEXT NOT NULL,
                clothing_category TEXT NOT NULL,
                size INTEGER NOT NULL,
                id_author INTEGER NOT NULL,
                creation_date NUMERIC NOT NULL,
                FOREIGN KEY(id_author) REFERENCES modders(id)
            )";
    $pdo->exec($sql);

    echo "Database and table created successfully.";

    $sql = 'INSERT INTO modders (name, mdp, creation_date) VALUES ("nom2", "$2y$10$tAaitYXNxvubpT9.fqan/.EkX47YpQbMZ.ubCo5ns0FUXfsLDPwEW", DATE()),("nom1","$2y$10$tAaitYXNxvubpT9.fqan/.EkX47YpQbMZ.ubCo5ns0FUXfsLDPwEW", DATE())';
    $pdo->exec($sql);

    $sql = 'INSERT INTO mods (name, expansion, type, age, gender, clothing_category, size, id_author, creation_date) VALUES ("nom2", "expansion2", "bottom", "teen", "female", "sleepwear", 2, 1, DATE()),("nom1", "expansion1", "top", "child", "female", "casual",1, 1, DATE())';
    $pdo->exec($sql);

    echo "Dataset inserted successfully.";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
