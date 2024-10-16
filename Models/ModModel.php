<?php
require_once "Core/db.php";
require_once "Entities/Mod.php";

class ModModel extends DB {

      public function create(Mod $mod) {
            $stmt = $this->pdo->prepare("INSERT INTO mods (name, expansion, type, age, gender, clothing_category, size, id_author) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$mod->getName(), $mod->getExpansion(), $mod->getType(), $mod->getAge(), $mod->getGender(), $mod->getClothingCategory(), $mod->getSize(), $mod->getIdAuthor()]);
      }

      public function read(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM mods WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
      }

      public function readAll() {
            $stmt = $this->pdo->query("SELECT * FROM mods");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
    
      public function update(Mod $mod, int $id) {
            $stmt = $this->pdo->prepare("UPDATE mods SET name = ?, expansion = ?, type = ?, age = ?, gender = ?, clothing_category = ?, size = ?, id_author= ? WHERE id = ?");
            return $stmt->execute([$mod->getName(), $mod->getExpansion(), $mod->getType(), $mod->getAge(), $mod->getGender(), $mod->getClothingCategory(), $mod->getSize(), $mod->getIdAuthor(), $id]);
      }

      public function delete(int $id) {
            $stmt = $this->pdo->prepare("DELETE FROM mods WHERE id = ?");
            return $stmt->execute([$id]);
      }
}