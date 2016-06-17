<?php
/**
 * File name: eagle.spec.php
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

use Project1\Eagle;

describe('Project1\Eagle;', function () {
    describe('->__construct()', function () {
        it('should return an Eagle object', function () {
            $eagle = new Eagle();
            expect($eagle)->to->be->instanceof('Project1\Eagle');
        });
        it('should return a default speed of 50', function () {
            $eagle = new Eagle();
            expect($eagle->getSpeed())->to->equal(50);
        });
    });
    describe('->hasFeathers()', function () {
        it('should return true', function () {
            $actual = new Eagle();
            expect($actual->hasFeathers())->to->be->true();
        });
    });
});
