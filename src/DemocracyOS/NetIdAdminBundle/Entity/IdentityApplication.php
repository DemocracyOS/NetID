<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DemocracyOS\NetIdApiBundle\Entity\Application;

/**
 * IdentityApplication
 *
 * @ORM\Entity
 * @ORM\Table(name="identity_application")
 */
class IdentityApplication
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
    }

	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Identity", inversedBy="applications")
     * @ORM\JoinColumn(name="identity", referencedColumnName="id", nullable=false)
     */
    protected $identity;

    /**
     * @ORM\ManyToOne(targetEntity="\DemocracyOS\NetIdApiBundle\Entity\Application", inversedBy="identities")
     * @ORM\JoinColumn(name="application", referencedColumnName="id", nullable=false)
     */
    protected $application;

	/**
     * @ORM\Column(name="foreign_id", nullable=false)
     */
    protected $foreignId;

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
     * Set foreignId
     *
     * @param string $foreignId
     * @return IdentityApplication
     */
    public function setForeignId($foreignId)
    {
        $this->foreignId = $foreignId;

        return $this;
    }

    /**
     * Get foreignId
     *
     * @return string 
     */
    public function getForeignId()
    {
        return $this->foreignId;
    }

    /**
     * Set identity
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Identity $identity
     * @return IdentityApplication
     */
    public function setIdentity(\DemocracyOS\NetIdAdminBundle\Entity\Identity $identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return \DemocracyOS\NetIdAdminBundle\Entity\Identity 
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set application
     *
     * @param \DemocracyOS\NetIdApiBundle\Entity\Application $application
     * @return IdentityApplication
     */
    public function setApplication(\DemocracyOS\NetIdApiBundle\Entity\Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \DemocracyOS\NetIdApiBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }
}
