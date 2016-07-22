<?php
/**
 * File name: Matcher.php
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

use Project1\Domain\UserRepository;
use Project1\Domain\ValueObject;

/**
 * Class Matcher
 * @category  PHP
 * @package   Project1\Services
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
abstract class Matcher
{
    /** @var \Project1\Domain\UserRepository */
    protected $repo;

    abstract public function match(ValueObject $value);

    /**
     * Matcher constructor
     * @param \Project1\Domain\UserRepository $repo
     */
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }
}
