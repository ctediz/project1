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

        $stmt = "CREATE TABLE IF NOT EXISTS users (id INT(4) AUTO_INCREMENT PRIMARY KEY, email VARCHAR(30) NOT NULL, 
                      userId VARCHAR(30) NOT NULL, name VARCHAR(30) NOT NULL, username VARCHAR(30) NOT NULL)";
        $this->driver->exec($stmt);
    }

    /**
     * @param \Project1\Domain\User $user
     * @return $this
     * @throws \PDOException
     */
    public function add(User $user)
    {
        $data = json_decode(json_encode($user),true);

        $email = $user->getEmail();
        $id = $user->getId();
        $name = $user->getName();
        $username = $user->getUsername();

        $stmt = $this->driver->prepare("INSERT INTO users (email, userId, name, username) 
            VALUES(?,?,?,?)");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $id);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $username);

        $stmt->execute();

        return $this;
    }

    /**
     * @param \Project1\Domain\StringLiteral $id
     * @return $this
     */
    public function delete(StringLiteral $id)
    {
        $stmt = $this->driver->prepare("DELETE FROM users WHERE userId=?");
        $stmt->execute([$id->toNative()]);
        
        return $this;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $output = [];

        $stmt = $this->driver->query('SELECT * FROM users');
        foreach($stmt as $row) {
            $output[] = $this->createUser($row);
        }

        return $output;
    }

    /**
     * @param \Project1\Domain\StringLiteral $fragment
     * @return array
     */
    public function findByEmail(StringLiteral $fragment)
    {
        $data = [];
        $search = "%$fragment%";
        $stmt = $this->driver->prepare("SELECT * FROM users WHERE email LIKE ?");
        $stmt->execute([$search]);

        while($row = $stmt->fetch())
        {
            $data[] = $this->createUser($row);
        }
        return $data;
    }

    /**
     * @param \Project1\Domain\StringLiteral $id
     * @return \Project1\Domain\User
     */
    public function findById(StringLiteral $id)
    {
        $stmt = $this->driver->prepare("SELECT * FROM users WHERE userId=?");
        $stmt->execute([$id->toNative()]);

        $userData = $stmt->fetch();
        if($userData)
            $user = $this->createUser($userData);
        else
            return;

        return $user;
    }

    /**
     * @param \Project1\Domain\StringLiteral $fragment
     * @return array
     */
    public function findByName(StringLiteral $fragment)
    {
        $data = [];
        $search = "%$fragment%";
        $stmt = $this->driver->prepare("SELECT * FROM users WHERE name LIKE ?");
        $stmt->execute([$search]);

        while($row = $stmt->fetch())
        {
            $data[] = $this->createUser($row);
        }
        return $data;
    }

    /**
     * @param \Project1\Domain\StringLiteral $username
     * @return array
     */
    public function findByUsername(StringLiteral $username)
    {
        $data = [];
        $search = "%$username%";
        $stmt = $this->driver->prepare("SELECT * FROM users WHERE username LIKE ?");
        $stmt->execute([$search]);

        while($row = $stmt->fetch())
        {
            $data[] = $this->createUser($row);
        }
        return $data;
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
     * @param array $userArray
     * @return User
     */
    private function createUser(array $userArray) {
        if ($userArray['userId']) {
            $user = new User(
                new StringLiteral($userArray['email']),
                new StringLiteral($userArray['name']),
                new StringLiteral($userArray['username'])
            );
            $user->setId(new StringLiteral($userArray['userId']));
        }
        return $user;
    }
}
