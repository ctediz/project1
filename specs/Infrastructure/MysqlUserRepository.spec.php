<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/26/2016
 * Time: 7:33 PM
 */

use Project1\Domain\User;
use Project1\Domain\StringLiteral;
use Project1\Infrastructure\MysqlUserRepository;

describe('Project1\src\Infrastructure\MysqlUserRepository', function() {
    $host = '192.168.99.100:3306';
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
    $this->pdo = new PDO($dsn, $user, $pass, $opt);

    $this->repo = new MysqlUserRepository($this->pdo);

    $faker = Faker\Factory::create();
    /** @var \Project1\Domain\User user */
    $this->user = new User(
        //$this->email = new StringLiteral($faker->email),
        $this->email = new StringLiteral("test@email.com"),
        $this->name = new StringLiteral($faker->name),
        $this->username = new StringLiteral($faker->username)
    );
    $this->id = new StringLiteral('testId');

    $this->user->setId($this->id);

    describe('->__constructor()', function() {
        it('should return a MysqlUserRepository', function() {

            expect($this->repo)->to->be->instanceof('Project1\Infrastructure\MysqlUserRepository');
        });
    });
    describe('->add(user)', function() {
        it('should add a user', function() {
            $this->repo->add($this->user);

            it('should return a matching user', function() {
                $result = $this->repo->findById($this->id);

                expect($result)->to->be->instanceof('\Project1\Domain\User');
                expect($result->getId()->equal($this->user->getId()))->to->be->true;
            });

        });
    });
    describe('findAll()', function() {
        it('should return an array', function() {
            $result = $this->repo->findAll();

            expect($result)->to->be->an('array');
        });
    });
    describe('findByEmail(StringLiteral email)', function() {
        it('should return an array of users', function() {
            $result = $this->repo->findByEmail($this->email);

            expect($result)->to->be->an('array');
            expect($result[0])->to->be->instanceof('\Project1\Domain\User');
            expect($result[0]->getId()->equal($this->user->getId()))->to->be->true;
        });
    });
    describe('findByEmail(invalid)', function() {
        it('should return an empty array', function() {
            $result = $this->repo->findByEmail(new StringLiteral("-1"));

            expect($result)->to->be->an('array');
            expect(0 === count($result))->to->be->true;
        });
    });
    describe('findById(id)', function() {
        it('should return a matching user', function() {
            //$result = $this->repo->findById($this->id);

            //expect($result)->to->be->instanceof('\Project1\Domain\User');
            //expect($result->getId()->equal($this->user->getId()))->to->be->true;
            //expect($result->getId()->equal($this->id))->to->be->true;
        });
    });
    describe('findById(-1)', function() {
        it('should return null', function() {
            //$result = $this->repo->findById(new StringLiteral('-1'));

            //expect($result)->to->be->equal(null);
        });
    });
    describe('findByName()', function() {
        it('should return an array of users', function() {
            $result = $this->repo->findByName($this->name);

            expect($result)->to->be->an('array');
            expect($result[0])->to->be->instanceof('\Project1\Domain\User');
            expect($result[0]->getId()->equal($this->user->getId()))->to->be->true;
        });
    });
    describe('findByUsername()', function() {
        it('should return an array of users', function() {
            $result = $this->repo->findByUsername($this->username);

            expect($result)->to->be->an('array');
            expect($result[0])->to->be->instanceof('\Project1\Domain\User');
            expect($result[0]->getId()->equal($this->user->getId()))->to->be->true;
        });
    });
    describe('save()', function() {
        it('should return true', function() {
           $result = $this->repo->save();
            expect($result)->to->be->true;
        });
    });
    describe('update()', function() {
        it('should update the user', function() {
            $email = new StringLiteral("Test@email.com");
            $name = new StringLiteral("test tester");
            $username = new StringLiteral("TesterTesting");

            $user = new User(
               $email,
               $name,
               $username
            );
            $user->setId($this->user->getId());
            $this->repo->update($user);

            /** @var \Project1\Domain\User $result */
            $result = $this->repo->findById($this->user->getId());
            expect($this->id)->to->equal($user->getId());
            expect($email)->to->equal($user->getEmail());
            expect($name)->to->equal($user->getName());
            expect($username)->to->equal($user->getUsername());
        });

    });
    describe('->delete(id)', function() {
        it('should delete the specified user from the repo', function() {
            $this->repo->delete($this->id);
            it('should return null', function() {
                $result = $this->repo->findById($this->id);

                expect($result)->to->be->equal(null);
            });
        });
    });
});