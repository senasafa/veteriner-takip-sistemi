<?php
require_once 'config/config.php';
require_once 'app/controllers/PetController.php';

$controller = new PetController();
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_SESSION['role']) ? 'list' : 'login');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

switch ($action) {
    case 'login': $controller->loginPage($db); break;
    case 'register': $controller->registerPage(); break;
    case 'veterinerRegister': $controller->veterinerRegister($db); break;
    case 'registerCheck': $controller->registerCheck($db); break;
    case 'sendSahiplenBasvuru': $controller->sendSahiplenBasvuru($db); break;
    case 'updateBasvuru': $controller->updateBasvuru($db); break;
    case 'veterinerSavePet': $controller->veterinerSavePet($db); break;
    case 'saveYardim': $controller->saveYardim($db); break;
    case 'loginCheck': $controller->loginCheck($db); break;
    case 'logout': $controller->logout(); break;
    case 'view': $controller->view($db, $id); break;
    case 'saveReport': $controller->saveReport($db); break;
    case 'list': default: $controller->index($db); break;
    case 'customerSavePet': $controller->customerSavePet($db); break; // YENİ ROTA
}
?>