<?php
/**
 * File name: dodo.spec.php
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

use Project1\Dodo;

describe('Project1\Dodo;', function () {
    describe('->__construct()', function () {
        it('should return an Dodo object', function () {
            $actual = new Dodo();
            expect($actual)->to->be->instanceof('Project1\Dodo');
        });
        it('should return a default speed of 2', function () {
            $actual = new Dodo();
            expect($actual->getSpeed())->to->equal(2);
        });
    });
    describe('->hasFeathers()', function () {
        it('should return true', function () {
            $actual = new Dodo();
            expect($actual->hasFeathers())->to->be->true();
        });
    });
});
