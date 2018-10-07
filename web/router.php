<?php
use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;

$collection = new RouteCollection();

// example of using a redirect to another route
$collection->attachRoute(
    new Route(
        '/',
        array(
            '_controller' => 'team\a2\controller\HomeController::indexAction',
            'methods' => 'GET',
            'name' => 'Home'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/aboutus',
        array(
            '_controller' => 'team\a2\controller\HomeController::aboutus',
            'methods' => 'GET',
            'name' => 'aboutus'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/login/',
        array(
            '_controller' => 'team\a2\controller\CustomerController::Login',
            'methods' => ['GET','POST'],
            'name' => 'Login'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/signup/',
        array(
            '_controller' => 'team\a2\controller\CustomerController::Signup',
            'methods' => ['GET','POST'],
            'name' => 'Signup'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/logout/',
        array(
            '_controller' => 'team\a2\controller\CustomerController::Logout',
            'methods' => ['GET','POST'],
            'name' => 'Logout'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/user/',
        array(
            '_controller' => 'team\a2\controller\CustomerController::edit',
            'methods' => ['GET','POST'],
            'name' => 'edit'
        )
    )
);


$collection->attachRoute(
    new Route(
        '/account/',
        array(
        '_controller' => 'team\a2\controller\AccountController::indexAction',
        'methods' => 'GET',
        'name' => 'accountIndex'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/create/',
        array(
        '_controller' => 'team\a2\controller\AccountController::createAction',
        'methods' => ['GET','POST'],
        'name' => 'accountCreate'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/delete/:id',
        array(
        '_controller' => 'team\a2\controller\AccountController::deleteAction',
        'methods' => 'GET',
        'name' => 'accountDelete'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/update/:id',
        array(
        '_controller' => 'team\a2\controller\AccountController::updateAction',
        'methods' => 'GET',
        'name' => 'accountUpdate'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/transaction/:id',
        array(
        '_controller' => 'team\a2\controller\TransactionController::indexAction',
        'methods' => ['GET','POST'],
        'name' => 'transaction'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/withdraw/:id',
        array(
        '_controller' => 'team\a2\controller\TransactionController::withdraw',
        'methods' => ['GET','POST'],
        'name' => 'withdraw'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/deposit/:id',
        array(
        '_controller' => 'team\a2\controller\TransactionController::deposit',
        'methods' => ['GET','POST'],
        'name' => 'deposit'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/transfer/:id',
        array(
        '_controller' => 'team\a2\controller\TransactionController::transfer',
        'methods' => ['GET','POST'],
        'name' => 'transfer'
        )
    )
);

$router = new Router($collection);
$router->setBasePath('/');
