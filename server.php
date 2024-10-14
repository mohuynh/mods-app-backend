<?php
// api.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$request = explode('/', trim($requestUri, '/'));
switch ($method) {
    case 'GET':
        if (isset($request[0]) && $request[0] == 'mods') {
            if (isset($request[1])) {
                getMod($request[1]);
            } else {
                getMods();
            }
        }
        else if (isset($request[0]) && $request[0] == 'modders') {
            if (isset($request[1])) {
                getModder($request[1]);
            } else {
                getModders();
            }
        }
        break;

    case 'POST':
        if (isset($request[0]) && $request[0] == 'mods') {
            createMod();
        } else if (isset($request[0]) && $request[0] == 'modders') {
            createModder();
        }
        break;

    case 'PUT':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            updateMod($request[1]);
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            updateModder($request[1]);
        }
        break;

    case 'DELETE':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            deleteMod($request[1]);
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            deleteModder($request[1]);
        }
        break;

    case 'OPTIONS':
        // Ignore OPTIONS for preflighted requests
        break;

    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}

function getMods() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM mods");
    $mods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($mods);
}

function getMod($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM mods WHERE id = ?");
    $stmt->execute([$id]);
    $mod = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($mod);
}

function createMod() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO mods (name, author, expansion, type, age, gender, clothing_category, size) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$data['name'], $data['author'], $data['expansion'], $data['type'], $data['age'], $data['gender'], $data['clothing_category'], $data['size']])) {
        $lastInsertId = $pdo->lastInsertId();
        $sql = 'SELECT * FROM mods WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $lastInsertId]);
        $mod = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($mod);
    } else {
        echo json_encode(['message' => 'Mod creation failed']);
    }
}

function updateMod($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));
    $stmt = $pdo->prepare("UPDATE mods SET name = ?, author = ?, expansion = ?, type = ?, age = ?, gender = ?, clothing_category = ?, size = ? WHERE id = ?");
    if ($stmt->execute([$data->name, $data->author, $data->expansion, $data->type, $data->age, $data->gender, $data->clothing_category, $data->size, $id])) {
        $stmt = $pdo->prepare("SELECT * FROM mods WHERE id = ?");
        $stmt->execute([$id]);
        $mod = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($mod);
    } else {
        echo json_encode(['message' => 'Mod update failed']);
    }
}

function deleteMod($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM mods WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['message' => 'Mod deleted successfully']);
    } else {
        echo json_encode(['message' => 'Mod deletion failed']);
    }
}


//

function getModders() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM modders");
    $modders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($modders);
}

function getModder($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM modders WHERE id = ?");
    $stmt->execute([$id]);
    $modder = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($modder);
}

function createModder() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO modders (name, creation_date) VALUES (?, DATE())");
    if ($stmt->execute([$data['name']])) {
        $lastInsertId = $pdo->lastInsertId();
        $sql = 'SELECT * FROM modders WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $lastInsertId]);
        $modder = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($modder);
    } else {
        echo json_encode(['message' => 'Modder creation failed']);
    }
}

function updateModder($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"));
    $stmt = $pdo->prepare("UPDATE modders SET name = ? WHERE id = ?");
    if ($stmt->execute([$data->name, $id])) {
        $stmt = $pdo->prepare("SELECT * FROM modders WHERE id = ?");
        $stmt->execute([$id]);
        $modder = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($modder);
    } else {
        echo json_encode(['message' => 'Modder update failed']);
    }
}

function deleteModder($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM modders WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['message' => 'Mod deleted successfully']);
    } else {
        echo json_encode(['message' => 'Mod deletion failed']);
    }
}

?>
