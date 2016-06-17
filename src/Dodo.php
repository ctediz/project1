<?php
/**
 * File name: Dodo.php
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
 * Class Dodo
 * @category  PHP
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class Dodo extends Bird implements BirdInterface
{
    public function __construct($speed = 2)
    {
        parent::__construct($speed);
    }

    public function hasFeathers()
    {
        return true;
    }
}
