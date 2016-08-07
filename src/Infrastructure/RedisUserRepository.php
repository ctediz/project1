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
        $this->client = $newClient;
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
        $output = [];
        
        //$result = $this->client->scan(0);
        $result = $this->client->keys('*');
        foreach($result as $key) {
            $output[] = $this->findById(new StringLiteral($key));
        }
        return $output;
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment)
    {
        $output = [];
        $data = $this->findAll();

        /** @var \Project1\Domain\User $user */
        foreach($data as $user) {
            $match = stripos($user->getEmail()->toNative(), $fragment->toNative());
            if(!($match === false))
                $output[] = $user;
        }

        return $output;
    }

    /**
     * @param StringLiteral $id
     * @return \Project1\Domain\User
     * @throws \InvalidArgumentException
     */
    public function findById(StringLiteral $id)
    {
        /** @var string $json */
        $json = $this->client->get($id->toNative());

        $data = json_decode($json);

        if (!($data === null)) {
            $user = new User(
                new StringLiteral($data->email),
                new StringLiteral($data->name),
                new StringLiteral($data->username)
            );
            $user->setId(new StringLiteral($data->id));
            return $user;
        }

        return null;
    }

    /**
     * @param StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment)
    {
        $output = [];
        $data = $this->findAll();

        /** @var \Project1\Domain\User $user */
        foreach($data as $user) {
            $match = stripos($user->getName()->toNative(), $fragment->toNative());
            if(!($match === false))
                $output[] = $user;
        }

        return $output;
    }

    /**
     * @param StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username)
    {
        $output = [];
        $data = $this->findAll();

        /** @var \Project1\Domain\User $user */
        foreach($data as $user) {
            $match = stripos($user->getUsername()->toNative(), $username->toNative());
            if(!($match === false))
                $output[] = $user;
        }

        return $output;
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
