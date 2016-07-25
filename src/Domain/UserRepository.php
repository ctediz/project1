<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/14/2016
 * Time: 8:37 PM
 */

// why doesn't it like this?
//namespace Project1\src\Domain;
namespace Project1\Domain;


use Project1\Domain\StringLiteral;
use Project1\Domain\User;

interface UserRepository
{
    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment);

    /**
     * @param StringLiteral $id
     * @return \Project1\Domain\User
     */
    public function findById(StringLiteral $id);

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment);

    /**
     * @param StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username);

    /**
     * @param User $user
     * @return $this
     */
    public function add(User $user);

    /**
     * @param StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id);

    /**
     * @return bool
     */
    public function save();

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function update(User $user);

    /**
     * @return array
     */
    public function findAll();
}