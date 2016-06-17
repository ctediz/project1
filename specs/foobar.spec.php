<?php
/**
 * File name: foobar.spec.php
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

use Project1\FooBar;

describe('Project1\FooBar;', function () {
    describe('->__construct()', function () {
        it('should return an FooBar object', function () {
            $actual = new FooBar();
            expect($actual)->to->be->instanceof('Project1\FooBar');
        });
        it('should return a default speed of 5000', function () {
            $actual = new FooBar();
            expect($actual->getSpeed())->to->equal(5000);
        });
        describe('->hasFeathers()', function () {
            it('should return true', function () {
                $actual = new FooBar();
                expect($actual->hasFeathers())->to->be->false();
            });
        });
    });
});
