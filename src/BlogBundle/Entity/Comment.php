<?php
// src/BlogBundle/Entity/User.php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use BlogBundle\Entity\User;
use BlogBundle\Entity\Post;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
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
    protected $commentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User $author
     *
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\User", inversedBy="comments", cascade={"persist", "merge"})
     */
    private $author;

    /**
     * @var Post $postCommented
     *
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Post", inversedBy="comments", cascade={"persist", "merge"})
     */
    private $postCommented;

    public function __construct()
    {
        $this->commentDate = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set commentDate
     *
     * @param \DateTime $commentDate
     *
     * @return Comment
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    /**
     * Get commentDate
     *
     * @return \DateTime
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * Set author
     *
     * @param \BlogBundle\Entity\User $author
     *
     * @return Comment
     */
    public function setAuthor(\BlogBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \BlogBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set postCommented
     *
     * @param \BlogBundle\Entity\Post $postCommented
     *
     * @return Comment
     */
    public function setPostCommented(\BlogBundle\Entity\Post $postCommented = null)
    {
        $this->postCommented = $postCommented;

        return $this;
    }

    /**
     * Get postCommented
     *
     * @return \BlogBundle\Entity\Post
     */
    public function getPostCommented()
    {
        return $this->postCommented;
    }
}
