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
use Project1\Infrastructure\MySQLUserRepository;
use Project1\Domain\StringLiteral;
use Project1\Domain\User;
use Pimple\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$dic = bootstrap();

$app = $dic['app'];
//$app['debug'] = true;

$app->get('/', function () use ($app) {
    return '<h1>Welcome to the Final Project</h1>';
});

$before = function (Request $request) {
    $password = $request->getPassword();
    $username = $request->getUser();

    if ($username !== 'professor') {
        $response = new Response();
        $response->headers->get('Content-Type', 'application/json');
        $response->setStatusCode(401);
        return $response;
    }
    if ($password !== '1234pass') {
        $response = new Response();
        $response->headers->get('Content-Type', 'application/json');
        $response->setStatusCode(401);
        return $response;
    }
};

$app->post('/auth/', function(Request $request) use ($app) {
    $response = new Response();
    $arrRequest = json_decode($request->getContent(), true);

    if($arrRequest['username']) // verify user/password is valid
    {
        // no db access - service unavailable

        // bad login - unauthorized

        // if good return verification
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->setContent("(verification code here)");
        return $response;
    }
    else // no content/missing username - un-processable
    {
        $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->setContent("Missing property: username");       // what to set content to?
        return $response;
    }

    // no storage - service unavailable
});

$app->delete('/users/{id}', function($id) use($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    $repo = $dic['repo-mem'];
    $result = $repo->delete(new StringLiteral($id))->save();
    if ($result === false) {
        $response->setStatusCode(500);
    } else {
        $response->setStatusCode(200);
    }
    return $response;
})
    ->before($before);

$app->get('/users/', function () use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    $repo = $dic['repo-mem'];
    $response->setStatusCode(200);
    $response->setContent(json_encode($repo->findAll()));
    return $response;
})
->before($before);

$app->get('/users/{id}', function ($id) use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    $repo = $dic['repo-mem'];
    $user = $repo->findById(new StringLiteral($id));
    if ($user === null) {
        $response->setStatusCode(404);
        return $response;
    }
    $response->setStatusCode(200);
    $response->setContent(json_encode($user));
    return $response;
})
->before($before);

$app->post('/users/', function(Request $request) use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');

    $arrRequest = json_decode($request->getContent(),true);

    if($arrRequest['email'] && $arrRequest['username'] && $arrRequest['name']) {
        $repo = $dic['repo-mem'];
        $email = $arrRequest['email'];
        $username = $arrRequest['username'];
        $name = $arrRequest['name'];

        $user = new User(new StringLiteral($email),
            new StringLiteral($name),
            new StringLiteral($username)
        );

        $repo->add($user);

        // id?
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->setContent(json_encode($user));
    }
    else{
        $responseJson['msg'] = 'Missing property';
        $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->setContent(json_encode($responseJson));
    }

    return $response;
})
->before($before);

$app->put('/users/{id}', function($id, Request $request) use($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    $repo = $dic['repo-mem'];
    
    $arrRequest = json_decode($request->getContent(),true);

    /** @var  $user Project1\Domain\User*/
    $user = $repo->findById(new StringLiteral($id));

    if($user === NULL) {
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $msg['msg'] = "Could not find $id";
        $response->setContent(json_encode($msg));
        return $response;
    }
    else {
        // get old values
        $email = $user->getEmail();
        $username = $user->getUsername();
        $name = $user->getName();
    }

    // replace old values if new exist
    if(!empty($arrRequest['email'])) {
        $email = $arrRequest['email'];
    }
    if(!empty($arrRequest['username'])) {
        $username = $arrRequest['username'];
    }
    if(!empty($arrRequest['name'])) {
        $name = $arrRequest['name'];
    }

    // update user
    $newUser = new User(
        new StringLiteral($email),
        new StringLiteral($name),
        new StringLiteral($username));
    $newUser->setId(new StringLiteral($id));
    $repo->update($newUser)->save();

    $response->setStatusCode(Response::HTTP_OK);
    return $response;
})
->before($before);

$app->post('/login/', function() use ($app) {
    $response = new Response();
    $response->setStatusCode(Response::HTTP_NOT_IMPLEMENTED);
    return $response;
    /*
    $arrRequest = json_decode($request->getContent(), true);

    $login = new loginModel();

    // verify request json
    foreach($login as $property=>$value)    // verify valid json
    {
        if(!$arrRequest[$property]) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->setContent("Missing property: $property");
            return $response;
        }
    }

    // verify server access - service unavailable
    // bad login - unauthorized

    // on success
    $response->setStatusCode(Response::HTTP_OK);    // not created?
    $response->setContent("Great!");
    return $response;
    */
})
->before($before);

$app->run();

function bootstrap()
{
    $dic = new Container();
    $dic['app'] = function() {
        return new Silex\Application();
    };
    $dic['db-driver'] = function() {
        $host = 'mysqlserver';
        $db   = 'dockerfordevs';
        $user = 'root';
        $pass = 'docker';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $user, $pass, $opt);
    };
    $pdo = $dic['db-driver'];
    $dic['repo-mysql'] = function() use ($pdo) {
        return new MysqlUserRepository($pdo);
    };
    $dic['repo-mem'] = function() {
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
        return $repoMem;
    };
    return $dic;
}