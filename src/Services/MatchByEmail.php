<?php
/**
 * File name: MatchByEmail.php
 * Project: project1
 * PHP version 5
 * @category  PHP
 * @package   Project1\Services
 * @author    donbstringham <donbstringham@gmail.com>
 * @copyright 2016 © donbstringham
 * @license   http://opensource.org/licenses/MIT MIT
 * @version   GIT: <git_id>
 * @link      http://donbstringham.us
 * $LastChangedDate$
 * $LastChangedBy$
 */

namespace Project1\Services;

use Project1\Domain\ValueObject;

/**
 * Class MatchByEmail
 * @category  PHP
 * @package   Project1\Services
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class MatchByEmail extends Matcher
{
    public function match(ValueObject $value)
    {
        /** @var \Project1\Domain\StringLiteral $value */
        return $this->repo->findByEmail($value);
    }
}
