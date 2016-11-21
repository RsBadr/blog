<?php
// src/BlogBundle/Entity/User.php

namespace BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="inscriptionDate", type="date")
     *
     */
    protected $inscriptionDate;

    /**
     * @ORM\Column(name="status", type="integer")
     *
     */
    protected $status;

    public function __construct()
    {
        parent::__construct();
        $this->inscriptionDate = new \DateTime();
        $this->status = 0;

        // your own logic
    }

    /**
     * Set inscriptionDate
     *
     * @param \DateTime $inscriptionDate
     *
     * @return User
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    /**
     * Get inscriptionDate
     *
     * @return \DateTime
     */
    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
