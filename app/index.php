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
use Pimple\Container;
use Project1\Infrastructure\InMemoryUserRepository;
use Project1\Infrastructure\MysqlUserRepository;
use Project1\Infrastructure\RedisUserRepository;
use Project1\Domain\StringLiteral;
use Project1\Domain\User;

require_once __DIR__ . '/../vendor/autoload.php';

$dic = bootstrap();

$app = $dic['app'];
$app['debug'] = true;

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

    if ($arrRequest['username']) // verify user/password is valid
    {
        // no db access - service unavailable

        // bad login - unauthorized

        // if good return verification
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->setContent("(verification code here)");
        return $response;
    } else // no content/missing username - un-processable
    {
        $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->setContent("Missing property: username");
        return $response;
    }
});

$app->get('/', function () {
    return '<h1>Welcome to the Final Project</h1>';
});

$app->get('/ping/', function() use ($dic) {
   $response = new Response();

    $driver = $dic['db-driver'];
    if (!$driver instanceof \PDO) {
        $response->setStatusCode(500);
        $msg = ['msg' => 'could not connect to the database'];
        $response->setContent(json_encode($msg));

        return $response;
    }

    $repo = $dic['repo-mysql'];
    if (!$repo instanceof \Project1\Domain\UserRepository) {
        $response->setStatusCode(500);
        $msg = ['msg' => 'repository problem'];
        $response->setContent(json_encode($msg));

        return $response;
    }

    $response->setStatusCode(Response::HTTP_OK);
    $response->headers->get('Content-Type', 'application/json');
    $msg = ['msg' => 'pong'];
    $response->setContent(json_encode($msg));

    //$msg[] = $repo->findAll();
    //$response->setContent(json_encode($msg));

    return $response;

});

$app->get('/users/', function () use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    //$repo = $dic['repo-mysql'];
    $repo = $dic['repo-redis'];
    $response->setStatusCode(200);
    $response->setContent(json_encode($repo->findAll()));
    return $response;
})
    ->before($before);

$app->get('/users/{id}', function ($id) use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    //$repo = $dic['repo-mem'];
    $repo = $dic['repo-mysql'];
    $user = $repo->findById(new StringLiteral($id));
    if ($user === null) {
        $msg = ["msg", "Could not find user $id"];
        $response->setStatusCode(404);
        $response->setContent(json_encode($msg));
        return $response;
    }
    $response->setStatusCode(200);
    $response->setContent(json_encode($user));
    return $response;
})
    ->before($before);

$app->delete('/users/{id}', function($id) use($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');
    //$repo = $dic['repo-mem'];
    $repo = $dic['repo-mysql'];

    $result = $repo->findById(new StringLiteral($id));
    if($result === null) {
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $msg = ["msg", "Could not find user $id"];
        $response->setContent(json_encode($msg));
        return $response;
    }

    $result = $repo->delete(new StringLiteral($id))->save();
    if ($result === false) {
        $response->setStatusCode(500);
    } else {
        $response->setStatusCode(200);
    }
    return $response;
})
    ->before($before);

$app->post('/users/', function(Request $request) use ($dic) {
    $response = new Response();
    $response->headers->get('Content-Type', 'application/json');

    $arrRequest = json_decode($request->getContent(),true);

    if($arrRequest['email'] && $arrRequest['username'] && $arrRequest['name'] && $arrRequest['id']) {
        //$repo = $dic['repo-mem'];
        $repoMySQL = $dic['repo-mysql'];
        $repoRedis = $dic['repo-redis'];
        $email = $arrRequest['email'];
        $username = $arrRequest['username'];
        $name = $arrRequest['name'];
        $id = $arrRequest['id'];

        $user = new User(new StringLiteral($email),
            new StringLiteral($name),
            new StringLiteral($username)
        );
        $user->setId(new StringLiteral($id));

        //$repo->add($user);
        $repoMySQL->add($user);
        $repoRedis->add($user);

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
    //$repo = $dic['repo-mem'];
    $repoMySQL = $dic['repo-mysql'];
    $repoRedis = $dic['repo-redis'];

    $arrRequest = json_decode($request->getContent(), true);

    /** @var  $user Project1\Domain\User*/
    $user = $repoMySQL->findById(new StringLiteral($id));

    if($user === NULL) {
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $msg['msg'] = "Could not find user $id";
        $response->setContent(json_encode($msg));
        return $response;
    }
    else {
        // get old values
        $email = $user->getEmail()->toNative();
        $username = $user->getUsername()->toNative();
        $name = $user->getName()->toNative();
    }

    // replace old values if new exist
    if(key_exists('email', $arrRequest)) {
        $email = $arrRequest['email'];
    }
    if(key_exists('username', $arrRequest)) {
        $username = $arrRequest['username'];
    }
    if(key_exists('name', $arrRequest)) {
        $name = $arrRequest['name'];
    }

    // update user
    $newUser = new User(
        new StringLiteral($email),
        new StringLiteral($name),
        new StringLiteral($username));
    $newUser->setId(new StringLiteral($id));
    $repoMySQL->update($newUser)->save();
    $repoRedis->update($newUser)->save();

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

    $dic['app'] = function () {
        return new Silex\Application();
    };

    $dic['db-driver'] = function () {
        $host = 'mysqlserver';
        $db = 'dockerfordevs';
        $user = 'root';
        $pass = 'docker';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, $user, $pass, $opt);
    };

    $pdo = $dic['db-driver'];
    $dic['repo-mysql'] = function () use ($pdo) {
        return new MysqlUserRepository($pdo);
    };

    $dic['redis-client'] = function() {
        return new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'redisserver',
            'port'   => 6379,
        ]);
    };
    $client = $dic['redis-client'];
    $dic['repo-redis'] = function() use ($client) {
        return new RedisUserRepository($client);
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