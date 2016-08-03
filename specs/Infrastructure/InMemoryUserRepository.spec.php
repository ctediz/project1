<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/14/2016
 * Time: 8:58 PM
 */

use Project1\Domain\User;
use Project1\Domain\StringLiteral;
use Project1\Infrastructure\InMemoryUserRepository;

describe('Project1\src\Infrastructure\InMemoryUserRepository', function() {
    beforeEach(function () {
        $this->repo = new InMemoryUserRepository();
        $faker = Faker\Factory::create();
        $user = new User(
            $this->email = new StringLiteral($faker->companyEmail),
            $this->name = new StringLiteral($faker->lastName),
            $this->userName = new StringLiteral($faker->userName)
        );
        $this->id = $user->setId(new StringLiteral('1a'));
        $this->repo->add($user);
    });

    describe('->__constructor()', function() {
        // test constructor
        it('should return InUserMemoryRepository object', function() {
            //$repo = new InMemoryUserRepository();
            expect($this->repo)->to->be->instanceof('Project1\Infrastructure\InMemoryUserRepository');
        });
    });

    describe('->add()', function()
    {
        it('should return an array', function() {
            $users = $this->repo->findByEmail($this->email);

            expect($users)->to->be->a('array');
            expect(1 === count($users))->to->be->true;
        });
    });

    describe('->findByEmail($this->email)', function()
    {
       it('should return an array', function() {
           $users = $this->repo->findByEmail($this->email);

           expect($users)->to->be->a('array');
           expect(1 === count($users))->to->be->true;
       });
    });

    describe('->findByEmail("")', function()
    {
        it('should return an empty array', function() {
            $users = $this->repo->findByEmail(new StringLiteral(""));

            expect($users)->to->be->a('array');
            expect(0 === count($users))->to->be->true;
        });
    });

    describe('->findById("1a")', function() {
        it('should return a User object', function() {
            /** @var \Project1\Domain\User $user */
            $user = $this->repo->findById(new StringLiteral('1a'));
            expect($user)->to->not->be->null;
            expect($user)->to->be->instanceof('Project1\Domain\User');
            expect($user->getId()->equal(new StringLiteral('1a')))->to->be->true;
        });
    });

    describe('->findById("2a")', function() {
       it('should return null', function() {
           $user = $this->repo->findById(new StringLiteral('2a'));
           expect($user)->to->be->null;
       });
    });

    describe('->delete("1a")', function() {
       it('should return a $this pointer after deleting the user', function() {
           $actual = $this->repo->delete(new StringLiteral('1a'));
           expect($actual)->to->be->instanceof('Project1\Infrastructure\InMemoryUserRepository');
           expect($this->repo->count())->to->equal(0);
       });
    });

    describe('->delete("")', function() {
        it('should return a $this pointer after deleting the user', function() {
            $actual = $this->repo->delete(new StringLiteral(''));
            expect($actual)->to->be->instanceof('Project1\Infrastructure\InMemoryUserRepository');
            expect($this->repo->count())->to->equal(1);
        });
    });
    
    describe('->findByUsername($this->Username)', function() {
        it('should return an array', function() {
            $users = $this->repo->findByUsername($this->name);

            expect($users)->to->be->a('array');
            expect(1 === count($users))->to->be->true;
        });
    });

    describe('->findByUsername("")', function() {
        it('should return an array', function() {
            $users = $this->repo->findByUsername(new StringLiteral(''));

            expect($users)->to->be->a('array');
            expect(0 === count($users))->to->be->true;
        });
    });
});

