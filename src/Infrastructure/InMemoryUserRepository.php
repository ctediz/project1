<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/14/2016
 * Time: 8:48 PM
 */

namespace Project1\Infrastructure;


use Project1\Domain\StringLiteral;
use Project1\Domain\UserRepository;
use Project1\Domain\User;

class InMemoryUserRepository implements UserRepository
{
    /** @var  array */
    protected $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment)
    {
        $responseStorage = [];
        /** @var \Project1\Domain\User $user */
        foreach($this->storage as $user)
        {
            if($fragment->equal($user->getEmail())) {
                $responseStorage[] = $user;
            }
        }
        return $responseStorage;
    }

    /**
     * @param StringLiteral $id
     * @return \Project1\Domain\User
     */
    public function findById(StringLiteral $id)
    {
        /** @var  $user */
        /** @var \Project1\Domain\User $user */
        foreach($this->storage as $user) {
            if ($id->equal($user->getId())) {
                return $user;
            }
        }

        // if not found
        return null;
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment)
    {
        $responseStorage = [];
        /** @var \Project1\Domain\User $user */
        foreach($this->storage as $user)
        {
            if($fragment->equal($user->getName())) {
                $responseStorage[] = $user;
            }
        }
        return $responseStorage;
    }

    /**
     * @param StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username)
    {
        $responseStorage = [];
        /** @var \Project1\Domain\User $user */
        foreach($this->storage as $user)
        {
            if($username->equal($user->getName())) {
                $responseStorage[] = $user;
            }
        }
        return $responseStorage;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function add(User $user)
    {
        $this->storage[] = $user;
        return $this;
    }

    /**
     * @param StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id)
    {
        for($i = 0; $i < $this->count(); $i++) {
            if ($id->equal($this->storage[$i]->getId())) {
                unset($this->storage[$i]);
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        return true;
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function update(User $user)
    {
        $this->delete($user->getId());
        $this->add($user);
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->storage;
    }
}