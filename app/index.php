<?php
/**
 * File name: index.php
 * Project: project1
 * PHP version 5
 * @category  PHP
 * @author    donbstringham <donbstringham@gmail.com>
 * @copyright 2016 © donbstringham
 * @license   http://opensource.org/licenses/MIT MIT
 * @version   GIT: <git_id>
 * @link      http://donbstringham.us
 * $LastChangedDate$
 * $LastChangedBy$
 */

use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Project1\Domain\StringLiteral;
use Project1\Domain\User;

require_once __DIR__ . '/../vendor/autoload.php';

$bill = new User(
    new StringLiteral('bill@email.com'),
    new StringLiteral('harris'),
    new StringLiteral('bharris')
);
$bill->setId(new StringLiteral('1'));

$charlie = new User(
    new StringLiteral('charlie@email.com'),
    new StringLiteral('fuller'),
    new StringLiteral('cfuller')
);
$charlie->setId(new StringLiteral('2'));

$dawn = new User(
    new StringLiteral('dawn@email.com'),
    new StringLiteral('brown'),
    new StringLiteral('dbrown')
);
$dawn->setId(new StringLiteral('3'));

$users = [
    $bill,
    $charlie,
    $dawn
];


$app = new Silex\Application();

$app->before(function (Request $request) {
    $password = $request->getPassword();
    $username = $request->getUser();

    if ($username !== 'professor') {
        $response = new Response();
        $response->setStatusCode(401);

        return $response;
    }

    if ($password !== '1234pass') {
        $response = new Response();
        $response->setStatusCode(401);

        return $response;
    }
});

$app->get('/', function () use ($app) {
    return '<h1>Welcome to the Final Project</h1>';
});

$app->get('/users', function () use ($app, $users) {
    $response = new Response();
    $response->setStatusCode(200);
    $response->setContent(json_encode($users));

    return $response;
});

$app->get('/users/{id}', function ($id) use ($app, $users) {
    $max = count($users);
    for ($i = 0; $i < $max; $i++) {
        $newId = new StringLiteral($id);
        if ($newId->equal($users[$i]->getId())) {
            $response = new Response();
            $response->setStatusCode(200);
            $response->setContent(json_encode($users[$i]));

            return $response;
        }
    }

    $response = new Response();
    $response->setStatusCode(404);

    return $response;
});

$app->run();
