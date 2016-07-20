<?php
/**
 * File name: UserRepository.php
 * Project: project1
 * PHP version 5
 * @category  PHP
 * @package   Project1\Domain
 * @author    donbstringham <donbstringham@gmail.com>
 * @copyright 2016 © donbstringham
 * @license   http://opensource.org/licenses/MIT MIT
 * @version   GIT: <git_id>
 * @link      http://donbstringham.us
 * $LastChangedDate$
 * $LastChangedBy$
 */

namespace Project1\Domain;

interface UserRepository
{
    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function add(User $user);

    /**
     * @param \Project1\Domain\StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id);

    /**
     * @return array
     */
    public function findAll();

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
     * @return bool
     */
    public function save();

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function update(User $user);
}
