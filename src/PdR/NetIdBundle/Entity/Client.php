<?php

namespace PdR\NetIdBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $application;

    /**
     * @ORM\OneToMany(targetEntity="Verb", mappedBy="application")
     */
    protected $verbs;

    public function __construct()
    {
        parent::__construct();
        $this->verbs = new ArrayCollection();
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
}