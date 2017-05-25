<?php

require_once "src/autoload.php";

use \models\Customer;
use \models\PDOCustomerRepository;
use \controllers\CustomerController;
use \views\JsonView;

$pdo = null;

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $requestBody = file_get_contents('php://input');

    $pdo = new PDO(".", "user", "pw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $jsonVIew = new JsonView();
    $customerRepository = new PDOCustomerRepository($pdo);
    $customerController = new CustomerController($customerRepository, $jsonVIew);

    $router = new AltoRouter();
    $router->setBasePath('/api.php');

    //customer mapping
    $router->map('GET', 'customers/[i:id]',
        function ($id) use ($customerController) {
            $customerController->handleFindById($id);
        }
    );

    $router->map('GET','/customers',
        function () use ($customerController) {
            $customerController->handleFindAll();
        }
    );

    $router->map('DELETE', 'customers/[i:id]',
        function ($id) use ($customerController) {
            $customerController->handleDeleteCustomer($id);
        }
    );

    $match = $router->match();
    if ($match && is_callable($match['target']))
    {
        call_user_func_array($match['target'], $match['param']);
    } else {
        echo '{404}';
    }

} catch (Exception $e) {
    print($e);
}