<?php
require_once "Core/db.php";
require_once "Entities/Modder.php";

class ModderModel extends DB {

      public function create(Modder $modder) {
            $stmt = $this->pdo->prepare("INSERT INTO modders (name, mdp, creation_date) VALUES (?, ?, DATE())");
            return $stmt->execute([$modder->getName(), $modder->getMdp()]);
      }

      public function read(int $id) {
            $stmt = $this->pdo->prepare('SELECT * FROM modders WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
      }

      public function readAll() {
            $stmt = $this->pdo->query("SELECT * FROM modders");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public function update(Modder $modder, int $id) {
            $stmt = $this->pdo->prepare("UPDATE modders SET name = ? WHERE id = ?");
            return $stmt->execute([$modder->getName(), $id]);
      }

      public function delete($id) {
            $stmt = $this->pdo->prepare("DELETE FROM modders WHERE id = ?");
            return $stmt->execute([$id]);
      }
}
