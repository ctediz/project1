<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/19/2016
 * Time: 8:58 PM
 */

namespace Project1\Infrastructure;

use Project1\Domain\StringLiteral;
use Project1\Domain\User;
use Project1\Domain\UserRepository;

class MySQLUserRepository implements UserRepository {
    public function __construct()
    {

    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment)
    {
        // TODO: Implement findByEmail() method.
    }

    /**
     * @param StringLiteral $id
     * @return \Project1\Domain\User
     */
    public function findById(StringLiteral $id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment)
    {
        // TODO: Implement findByName() method.
    }

    /**
     * @param StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username)
    {
        // TODO: Implement findByUsername() method.
    }

    /**
     * @param User $user
     * @return $this
     */
    public function add(User $user)
    {
        // TODO: Implement add() method.
    }

    /**
     * @param StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return bool
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function update(User $user)
    {
        // TODO: Implement update() method.
    }

    /**
     * @return array
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
}