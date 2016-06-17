<?php
/**
 * File name: Eagle.php
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
 * Class Eagle
 * @category  PHP
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
class Eagle extends Bird implements BirdInterface
{
    public  function __construct($speed = 50)
    {
        parent::__construct($speed);
    }

    public function hasFeathers()
    {
        return true; 
    }
}
