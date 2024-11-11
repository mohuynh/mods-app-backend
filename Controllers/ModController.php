<?php

require_once "vendor/autoload.php";

require_once "Models/ModModel.php";
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

    $auth = auth();
    $authId = $auth;

    if( $auth == false) {
        echo json_encode(['message' => 'You need to be logged in!']);
        return;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    
    $mod = new Mod();

    $mod->setName($data['name']);
    $mod->setExpansion($data['expansion']);
    $mod->setType($data['type']);
    $mod->setAge($data['age']);
    $mod->setGender($data['gender']);
    $mod->setClothingCategory($data['clothing_category']);
    $mod->setSize($data['size']);
    $mod->setIdAuthor($authId);

    $ModModel = new ModModel();
    
    if ($ModModel->create($mod)) {
        $lastInsertId = $ModModel->lastInsertId();  
        echo json_encode($ModModel->read($lastInsertId));
    } else {
        echo json_encode(['message' => 'Mod creation failed']);
    }

}

function updateMod($id) {

    $ModModel = new ModModel();
    $ModId = $ModModel->read($id);
    
    if($ModId == false) {
        echo json_encode(['message' => "Mod doesn't exist"]);
        return;
    }

    $auth = auth();

    if( $auth == false) {
        echo json_encode(['message' => 'You need to be logged in!']);
        return;
    }

    $authId = $auth;

    if ($ModId["id_author"] != $authId) {
        echo json_encode(['message' => "Cannot modify another user's mod"]);
        return;
    }

        $data = json_decode(file_get_contents("php://input"), true);

        $mod = new Mod();

        $mod->setName($data['name']);
        $mod->setExpansion($data['expansion']);
        $mod->setType($data['type']);
        $mod->setAge($data['age']);
        $mod->setGender($data['gender']);
        $mod->setClothingCategory($data['clothing_category']);
        $mod->setSize($data['size']);
        $mod->setIdAuthor($authId);

        if ($ModModel->update($mod,$id)) {
        
            echo json_encode($ModModel->read($id));
        } else {
            echo json_encode(['message' => 'Mod update failed']);
    }
}

function deleteMod($id) {

    $ModModel = new ModModel();
    $ModId = $ModModel->read($id);

    $auth = auth();

    if( $auth == false) {
        echo json_encode(['message' => 'You need to be logged in!']);
        return;
    }

    $authId = $auth;
    
    if ($authId != $ModId["id_author"]) {
        echo json_encode(['message' => "Cannot modify another user!"]);
        return;
    }
    
    if ($ModModel->delete($id)) {
        echo json_encode(['message' => 'Mod deleted successfully']);
    } else {
        echo json_encode(['message' => 'Mod deletion failed']);
    }
}

}

