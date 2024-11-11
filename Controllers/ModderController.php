<?php

require_once "vendor/autoload.php";

require_once "Models/ModModel.php";
require_once "Models/ModderModel.php";
require_once "Entities/Mod.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Secret key used to generate our JWTs
$jwt_secret_key = 'example_key';
$jwt_algorithm = 'HS256';

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
    $modder->setMdp(password_hash($data["mdp"],PASSWORD_DEFAULT));

    $ModderModel = new ModderModel();
    
    if (!$ModderModel->readByName($data["name"])) {
        if ($ModderModel->create($modder)) {
            $lastInsertId = $ModderModel->lastInsertId();
            echo json_encode($ModderModel->read($lastInsertId));
        } else {
            echo json_encode(['message' => 'Modder creation failed']);
        }
    }else {
        echo json_encode(['message' => 'Modder aldready exist']);
    }
}

function updateModder($id) {

    $auth = auth();

    if( $auth == false) {
        echo json_encode(['message' => 'You need to be logged in!']);
        return;
    }

    $authId = $auth;
    if ($authId != $id) {
        echo json_encode(['message' => "Cannot modify another user!"]);
        return;
    }

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

    $auth = auth();

    if( $auth == false) {
        echo json_encode(['message' => 'You need to be logged in!']);
        return;
    }

    $authId = $auth;
    if ($authId != $id) {
        echo json_encode(['message' => "Cannot modify another user!"]);
        return;
    }

    $ModderModel = new ModderModel();

    if ($ModderModel->delete($id)) {
        echo json_encode([]);
    } else {
        echo json_encode(['message' => 'Modder deletion failed']);
    }

}

function login() {
    $data = json_decode(file_get_contents("php://input"), true);

    $ModderModel = new ModderModel();

    $result = $ModderModel->readByName($data["name"]);

    if($result && password_verify($data["mdp"], $result["mdp"])) {
        
        $CurrentTime = time();

        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => $CurrentTime,
            'nbf' => $CurrentTime,
            // exp = time + 2h
            'exp' => $CurrentTime + 2*60*60,
            'userid' => $result["id"],
            'username' => $result["name"]
        ];
        
        // Encode headers in the JWT string
        global $jwt_secret_key;
        global $jwt_algorithm;
        $jwt = JWT::encode($payload, $jwt_secret_key, $jwt_algorithm);

        echo json_encode($jwt);

    } else {
        echo json_encode(['message' => 'Connexion failed']);
    }
}
}

// Authentification
function auth() {

    $headers = apache_request_headers();
    if(!isset($headers["Authorization"])) {
        return false;
    }

    $jwtToken = explode(' ', $headers["Authorization"])[1];

    global $jwt_secret_key;
    global $jwt_algorithm;

    try {
        $decoded = JWT::decode($jwtToken, new Key($jwt_secret_key, $jwt_algorithm));
    } catch (Exception $e){
        return false;
    }
    return $decoded->userid;
}
