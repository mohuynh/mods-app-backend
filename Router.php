<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Core/db.php';
include 'Controllers/server.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$request = explode('/', trim($requestUri, '/'));

$controller = new ModController();
$ModderController = new ModderController();

switch ($method) {
    case 'GET':
        if (isset($request[0]) && $request[0] == 'mods') {
            if (isset($request[1])) {
                $controller->getMod($request[1]);
            } else {
                $controller->getMods();
            }
        }
        else if (isset($request[0]) && $request[0] == 'modders') {
            if (isset($request[1])) {
                $ModderController->getModder($request[1]);
            } else {
                $ModderController->getModders();
            }
        }
        break;

    case 'POST':
        if (isset($request[0]) && $request[0] == 'mods') {
            $controller->createMod();
        } else if (isset($request[0]) && $request[0] == 'modders') {
            $ModderController->createModder();
        }
        break;

    case 'PUT':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            $controller->updateMod($request[1]);
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            $ModderController->updateModder($request[1]);
        }
        break;

    case 'DELETE':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            $controller->deleteMod($request[1]);
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            $ModderController->deleteModder($request[1]);
        }
        break;

    case 'OPTIONS':
        // Ignore OPTIONS for preflighted requests
        break;

    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}