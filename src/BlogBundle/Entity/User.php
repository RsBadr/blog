<?php
// src/BlogBundle/Entity/User.php

namespace BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use BlogBundle\Entity\Post;
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
     * @ORM\Column(name="statut", type="integer")
     *
     */
    protected $statut;

    /**
     * @var ArrayCollection $departements
     *
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Post", mappedBy="author", cascade={"persist", "remove", "merge"})
     */
    private $posts;

    public function __construct()
    {
        parent::__construct();
        $this->inscriptionDate = new \DateTime();
        $this->status = 0;
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
     * Add post
     *
     * @param \BlogBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\BlogBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \BlogBundle\Entity\Post $post
     */
    public function removePost(\BlogBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return User
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
