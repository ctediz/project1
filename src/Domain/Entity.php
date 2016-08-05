<?php
/**
 * File name: Entity.php
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
 * Interface Entity
 * @category  PHP
 * @package   Project1\Domain
 * @author    donbstringham <donbstringham@gmail.com>
 * @link      http://donbstringham.us
 */
interface Entity extends \JsonSerializable
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id);
}
