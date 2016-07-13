<?php
/**
 * File name: User.spec.php
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

use Project1\Domain\User;
use Project1\Domain\StringLiteral;

describe('Project1\Domain\User', function () {
    beforeEach(function () {
        $this->faker = Faker\Factory::create();
    });
    describe('->__construct()', function () {
        it('should return a User object', function () {

            $user = new User(
                new StringLiteral($this->faker->companyEmail),
                new StringLiteral($this->faker->lastName),
                new StringLiteral($this->faker->userName)
            );
            expect($user)->to->be->instanceof('Project1\Domain\User');
        });
    });
    describe('->__toString()', function () {
        it('should return a string of the User object', function () {
            $user = new User(
                new StringLiteral('bill@email.com'),
                new StringLiteral('jones'),
                new StringLiteral('bjones')
            );
            // TODO: Fix unit-test
//            expect((string)$user)->equal('O:20:"Project1\Domain\User":4:{s:8:"*email";O:29:"Project1\Domain\StringLiteral":1:{s:8:"*value";s:14:"bill@email.com";}s:5:"*id";N;s:7:"*name";O:29:"Project1\Domain\StringLiteral":1:{s:8:"*value";s:5:"jones";}s:11:"*username";O:29:"Project1\Domain\StringLiteral":1:{s:8:"*value";s:6:"bjones";}}');
        });
    });
});
