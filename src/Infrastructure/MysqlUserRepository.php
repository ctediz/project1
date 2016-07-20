<?php
/**
 * File name: MysqlUserRepository.php
 * Project: project1
 * PHP version 5
 * @category  PHP
 * @package   Project1\Infrastructure
 * @author    donbstringham <donbstringham@gmail.com>
 * @copyright 2016 © donbstringham
 * @license   http://opensource.org/licenses/MIT MIT
 * @version   GIT: <git_id>
 * @link      http://donbstringham.us
 * $LastChangedDate$
 * $LastChangedBy$
 */

namespace Project1\Infrastructure;

use Project1\Domain\StringLiteral;
use Project1\Domain\User;
use Project1\Domain\UserRepository;

/**
 * Class MysqlUserRepository
 * @category  PHP
 * @package   Project1\Infrastructure
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class MysqlUserRepository implements UserRepository
{
    /** @var \PDO */
    protected $driver;

    /**
     * MysqlUserRepository constructor
     * @param \PDO $driver
     */
    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function add(User $user)
    {
        $stmt = $this->driver->exec("INSERT BLAH");
        $this->driver->prepare($stmt);
        $stmt->exec();
    }

    /**
     * @param \Project1\Domain\StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id)
    {
        // TODO: Implement delete() method
    }

    /**
     * @return array
     */
    public function findAll()
    {
        // TODO: Implement findAll() method
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment)
    {
        // TODO: Implement findByEmail() method
    }

    /**
     * @param StringLiteral $id
     * @return \Project1\Domain\User
     */
    public function findById(StringLiteral $id)
    {
        // TODO: Implement findById() method
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment)
    {
        // TODO: Implement findByName() method
    }

    /**
     * @param StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username)
    {
        // TODO: Implement findByUsername() method
    }

    /**
     * @return bool
     */
    public function save()
    {
        // TODO: Implement save() method
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function update(User $user)
    {
        // TODO: Implement update() method
    }
}
