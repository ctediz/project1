<?php
/**
 * File name: Bird.php
 * Project: project1
 * PHP version 5
 * @category  PHP
 * @author    donbstringham <donbstringham@gmail.com>
 * @copyright 2016 © donbstringham
 * @license   http://opensource.org/licenses/MIT MIT
 * @version   GIT: <git_id>
 * @link      http://donbstringham.us
 * $LastChangedDate$
 * $LastChangedBy$
 */

namespace Project1;

/**
 * Class Bird
 * @category  PHP
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class Bird
{
    private $speed;

    public function __construct($speed = 0)
    {
        if ($speed < 0) {
            throw new \RuntimeException('$speed can only be 0 or greater');
        }

        $this->speed = $speed;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }
}
