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
use Symfony\Component\HttpFoundation\Response;
use Project1\Infrastructure\InMemoryUserRepository;
use Project1\Infrastructure\MysqlUserRepository;
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

$repoMem = new InMemoryUserRepository();
$repoMem->add($bill)->add($charlie)->add($dawn);

$host = 'mysqlserver';
$port = 3306;
$db   = 'dockerfordevs';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$driver = new PDO($dsn, $user, $pass, $opt);
$repoDb = new MysqlUserRepository($driver);

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

$app->get('/users', function () use ($app, $repoMem) {
    $response = new Response();
    $response->setStatusCode(200);
    $response->setContent(json_encode($repoMem->findAll()));

    return $response;
});

$app->get('/users/{id}', function ($id) use ($app, $repoDb) {
    $response = new Response();
    $user = $repoDb->findById(new StringLiteral($id));
    if ($user === null) {
        $response->setStatusCode(404);

        return $response;
    }

    $response->setStatusCode(200);
    $response->setContent(json_encode($user));

    return $response;
});

$app->delete('/users/{id}', function ($id) use ($app, $repo) {
    $response = new Response();

    $result = $repo->delete(new StringLiteral($id))->save();

    if ($result === false) {
        $response->setStatusCode(500);
    } else {
        $response->setStatusCode(200);
    }

    return $response;
});

$app->post('/users', function (Request $request) use ($app, $repo) {
    $response = new Response();
    $response->setStatusCode(501);

    return $response;
});

$app->put('/users/{id}', function ($id, Request $request) use ($app, $repo) {
    $response = new Response();
    $response->setStatusCode(501);

    return $response;
});

$app->run();
