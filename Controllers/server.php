<?php

require_once "Models/ModModel.php";
require_once "Models/ModderModel.php";
require_once "Entities/Mod.php";

// table Mods
class ModController {
function getMods() {
    $ModModel = new ModModel();
    
    echo json_encode($ModModel->readAll());
}

function getMod($id) {
    $ModModel = new ModModel();

    echo json_encode($ModModel->read($id));
}

function createMod() {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $mod = new Mod();

    $mod->setName($data['name']);
    $mod->setExpansion($data['expansion']);
    $mod->setType($data['type']);
    $mod->setAge($data['age']);
    $mod->setGender($data['gender']);
    $mod->setClothingCategory($data['clothing_category']);
    $mod->setSize($data['size']);
    $mod->setIdAuthor($data['id_author']);

    $ModModel = new ModModel();
    
    if ($ModModel->create($mod)) {
        $lastInsertId = $ModModel->lastInsertId();  
        echo json_encode($ModModel->read($lastInsertId));
    } else {
        echo json_encode(['message' => 'Mod creation failed']);
    }
}

function updateMod($id) {
    $data = json_decode(file_get_contents("php://input"), true);

    $mod = new Mod();

    $mod->setName($data['name']);
    $mod->setExpansion($data['expansion']);
    $mod->setType($data['type']);
    $mod->setAge($data['age']);
    $mod->setGender($data['gender']);
    $mod->setClothingCategory($data['clothing_category']);
    $mod->setSize($data['size']);
    $mod->setIdAuthor($data['id_author']);

    $ModModel = new ModModel();

    if ($ModModel->update($mod,$id)) {
        
        echo json_encode($ModModel->read($id));
    } else {
        echo json_encode(['message' => 'Mod update failed']);
    }
}

function deleteMod($id) {
    $ModModel = new ModModel();
    
    if ($ModModel->delete($id)) {
        echo json_encode(['message' => 'Mod deleted successfully']);
    } else {
        echo json_encode(['message' => 'Mod deletion failed']);
    }
}
}


// table Modders


class ModderController {
function getModders() {
    $ModderModel = new ModderModel();

    echo json_encode($ModderModel->readAll());
}

function getModder($id) {
    $ModderModel = new ModderModel();

    echo json_encode($ModderModel->read($id));
}

function createModder() {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $modder = new modder();

    $modder->setName($data["name"]);

    $ModderModel = new ModderModel();
    
    if ($ModderModel->create($modder)) {
        $lastInsertId = $ModderModel->lastInsertId();
        echo json_encode($ModderModel->read($lastInsertId));
    } else {
        echo json_encode(['message' => 'Modder creation failed']);
    }
}

function updateModder($id) {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $modder = new Modder();

    $modder->setName($data["name"]);

    $ModderModel = new ModderModel();
    if ($ModderModel->update($modder, $id)) {
        echo json_encode($ModderModel->read($id));
    } else {
        echo json_encode(['message' => 'Modder update failed']);
    }
}

function deleteModder($id) {
    $ModderModel = new ModderModel();
    if ($ModderModel->delete($id)) {
        echo json_encode(['message' => 'Mod deleted successfully']);
    } else {
        echo json_encode(['message' => 'Mod deletion failed']);
    }
}
}

?>
