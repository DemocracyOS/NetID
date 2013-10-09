<?php

namespace PdR\NetIdBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Client extends BaseClient
{
    const APPLICATION_DEMOCRACY_OS = 'democracyos';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true, nullable=false)
     * @Expose
     */
    protected $application;

    /**
     * @ORM\OneToMany(targetEntity="Verb", mappedBy="application")
     */
    protected $verbs;

    /**
     * @ORM\OneToMany(targetEntity="UsersClients", mappedBy="client")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="client")
     */
    protected $tokens;

    public function __construct()
    {
        parent::__construct();
        $this->verbs = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getApplication()
    {
        return $this->application;
    }


    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
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
     * Add verbs
     *
     * @param \PdR\NetIdBundle\Entity\Verb $verbs
     * @return Client
     */
    public function addVerb(\PdR\NetIdBundle\Entity\Verb $verbs)
    {
        $this->verbs[] = $verbs;
    
        return $this;
    }

    /**
     * Remove verbs
     *
     * @param \PdR\NetIdBundle\Entity\Verb $verbs
     */
    public function removeVerb(\PdR\NetIdBundle\Entity\Verb $verbs)
    {
        $this->verbs->removeElement($verbs);
    }

    /**
     * Get verbs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVerbs()
    {
        return $this->verbs;
    }

    /**
     * Add users
     *
     * @param \PdR\NetIdBundle\Entity\UsersClients $users
     * @return Client
     */
    public function addUser(\PdR\NetIdBundle\Entity\UsersClients $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \PdR\NetIdBundle\Entity\UsersClients $users
     */
    public function removeUser(\PdR\NetIdBundle\Entity\UsersClients $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->application;
    }
}