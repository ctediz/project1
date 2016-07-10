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

$app = new Silex\Application();

$app->get('/', function () use ($app) {
    return '<h1>Welcome to Project 1</h1>';
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return '<p>Hello <b>' . $app->escape($name) . '</b></p>';
});

$app->run();
