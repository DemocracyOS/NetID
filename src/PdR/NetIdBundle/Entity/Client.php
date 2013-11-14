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
     * @ORM\OneToMany(targetEntity="IdentitiesClients", mappedBy="client")
     */
    protected $identities;

    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="client")
     */
    protected $tokens;

    public function __construct()
    {
        parent::__construct();
        $this->verbs = new ArrayCollection();
        $this->identities = new ArrayCollection();
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
     * Add identity
     *
     * @param \PdR\NetIdBundle\Entity\IdentitiesClients $identity
     * @return Client
     */
    public function addIdentity(\PdR\NetIdBundle\Entity\IdentitiesClients $identity)
    {
        $this->identities[] = $identity;
    
        return $this;
    }

    /**
     * Remove identity
     *
     * @param \PdR\NetIdBundle\Entity\IdentitiesClients $identities
     */
    public function removeIdentity(\PdR\NetIdBundle\Entity\IdentitiesClients $identity)
    {
        $this->identities->removeElement($identity);
    }

    /**
     * Get identities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdentities()
    {
        return $this->identities;
    }

    public function __toString()
    {
        return $this->application;
    }
}