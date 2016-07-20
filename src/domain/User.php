<?php
/**
 * File name: User.php
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

/**
 * Class User
 * @category  PHP
 * @package   Project1\Domain
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class User implements Entity
{
    /** @var \Project1\Domain\StringLiteral */
    protected $email;
    /** @var \Project1\Domain\StringLiteral */
    protected $id;
    /** @var \Project1\Domain\StringLiteral */
    protected $name;
    /** @var \Project1\Domain\StringLiteral */
    protected $username;

    /**
     * User constructor
     * @param \Project1\Domain\StringLiteral $email
     * @param \Project1\Domain\StringLiteral $name
     * @param \Project1\Domain\StringLiteral $username
     */
    public function __construct(
        StringLiteral $email,
        StringLiteral $name,
        StringLiteral $username
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function __toString()
    {
       return serialize($this);
    }

    /**
     * @return StringLiteral
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return StringLiteral
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return StringLiteral
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return StringLiteral
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param StringLiteral $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
       return get_object_vars($this);
    }
}
