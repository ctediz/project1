<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 7/28/2016
 * Time: 7:45 PM
 */

namespace Project1\Infrastructure;

use Predis\Client;
use Project1\Domain\StringLiteral;
use Project1\Domain\User;
use Project1\Domain\UserRepository;

class RedisUserRepository implements UserRepository
{
    /** @var  \Predis\Client() */
    protected $client;


    /**
     * RedisUserRepository constructor.
     * @param Client $newClient
     */
    public function __construct(Client $newClient)
    {
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     */
    public function add(User $user)
    {
        $this->client->set($user->getId()->toNative(), json_encode($user));
        return $this;
    }

    /**
     * @param \Project1\Domain\StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id)
    {
        $this->client->del([$id->toNative()]);
        return $this;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
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
        /** @var string $json */
        $json = $this->client->get($id->toNative());

        $data = json_decode($json, true);
        $user = new User(
            new StringLiteral($data->email),
            new StringLiteral($data->name),
            new StringLiteral($data->username)
        );
        $user->setId($id);

        return $user;
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
}