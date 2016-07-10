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

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Project1\userModel;
use Project1\loginModel;

$app = new Silex\Application();
//$app['debug'] = true;

$app->get('/hello/', function () use ($app) {
    return '<h1>Welcome to Project 1</h1>';
});

$before = function (Request $request) {
    $headers = $request->headers;
    $token = $headers->get('Authorization');
    if ($token !== '1') {
        $msg = __FILE__ . ': hey I do NOT know you get a valid dev token';
        echo $msg;
        throw new \RuntimeException($msg);
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

$app->post('/users/', function(Request $request) use ($app) {
    $arrRequest = json_decode($request->getContent(),true);
    $user = new userModel();
    $response = new Response();

    // check for needed values
    // use a user model and loop through model's key values to check for null
    // if a value is null set 422 unprocessable entry
    // on success, response is 201 and return where to get to new user
    foreach($user as $property => $value)
    {
        if($arrRequest[$property])
        {
            $user->$property = $arrRequest[$property];
        }
        else{
            // if missing property
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->headers->set('Content-Type', 'text/html');
            $response->setContent("Missing property: $property");
            $response->prepare($request);
            //$response->send();
            return $response;
        }
    }

    // input into database
    // if successful return response

    // send response
    $response->setContent(json_encode(get_object_vars($user)));
    $response->headers->set('Content-Type', 'application/json');
    $response->setStatusCode(Response::HTTP_CREATED);
    $response->prepare($request);
    //$response->send();

    // else, return storage unavailable

    return $response;
});

$app->get('/users/', function(Request $request) use($app) {
    $response = new Response();
    // get from database here!
    $data = [
        'count' => 4,
        'users' => [
            ['username' => 'jason',
                'email' => 'jason@email.com',
                'name' => 'real jason'
            ],
            ['username' => 'notjason',
                'email' => 'notjason@email.com',
                'name' => 'real jason'
            ],
            ['username' => 'notjason2',
                'email' => 'maybejason@email.com',
                'name' => 'maybe jason'
            ],
            ['username' => 'notjason3',
                'email' => 'fakejason@email.com',
                'name' => 'fake jason'
            ]
        ]
    ];
    $newData['count'] = 0;

    // check for query parameters
    if($query = $request->query->all())
    {
        // filter by query parameters
        // loop through query string
        foreach($query as $key => $value)
        {
            // loop through users (db) arrays
            foreach($data['users'] as $user)
            {
                if($value == $user[$key])
                {
                    $newData['count']++;
                    $newData['users'] = $user;
                }

            }
        }
        $data = $newData;
    }

    // encode, return
    $content = json_encode($data);
    $response->setContent($content);
    $response->headers->set('Content-Type', 'application/json');
    $response->setStatusCode(Response::HTTP_OK);

    //$response->send();
    return $response;
})
->before($before);

$app->delete('/users/{id}', function(Request $request, $id) {
    $response = new Response();

    // validate id
        // return 404 not found on invalid id

    // delete from storage
        // return 503 service unavailable

    // return 200 on success
    $response->setStatusCode(Response::HTTP_OK);
    $response->prepare($request);
    $response->setContent("User $id deleted successfully");

    return $response;
})
->before($before);

$app->post('/login/', function(Request $request) use ($app) {
    $response = new Response();
    $arrRequest = json_Decode($request->getContent(), true);

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
})
->before($before);

$app->get('/hello/{name}', function ($name) use ($app) {
    return '<p>Hello <b>' . $app->escape($name) . '</b></p>';
});

$app->get('/cwd/', function() use($app) {
    return __DIR__;
});

$app->get('/server/', function() use($app) {
    //return phpinfo();     // not this one
    //return var_dump($_SERVER);    // contents of $_SERVER super global
    // $_SERVER['SERVER_SOFTWARE'] = "greatserver!";
    return $_SERVER['SERVER_SOFTWARE'];     // this can be changed!
});

$app->run();
