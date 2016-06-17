<?php
/**
 * File name: bird.spec.php
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

use Project1\Bird;

describe('Project1\Bird', function () {
    describe('->__construct()', function () {
        it('should return a Bird object', function () {
            $bird = new Bird();
            expect($bird)->to->be->instanceof('Project1\Bird');
        });
    });
    describe('->__construct(-1)', function () {
        it('should throw a RuntimeException object', function () {
            $exception  = null;

            try {
                new Bird(-1);
            } catch (\Exception $e) {
                $exception = $e;
            }

            expect($exception)->to->be->instanceof('\RuntimeException');
            expect($exception->getMessage())->to->equal(
                '$speed can only be 0 or greater'
            );
        });
    });
    describe('->getSpeed()', function () {
        it('should return the default speed of 0', function () {
            $bird = new Bird();
            expect($bird->getSpeed())->to->equal(0);
        });
    });
    describe('->getSpeed(1)', function () {
        it('should return the speed of 1', function () {
            $bird = new Bird(1);
            expect($bird->getSpeed())->to->equal(1);
        });
    });
    
});
