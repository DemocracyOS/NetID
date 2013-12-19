<?php

namespace DemocracyOS\NetIdApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication;


/**
 * @ORM\Entity
 */
class Application extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column()
     */
    protected $name;

    /**
     * @ORM\Column()
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="\DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication", mappedBy="applications")
     */
    protected $identities;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAllowedGrantTypes(array('client_credentials'));
        $this->identities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * toString
     */
    public function __toString()
    {
        if ($this->name)
        {
            return $this->name;
        } else {
            return 'New Application';
        }
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
     * Set name
     *
     * @param string $name
     * @return Application
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Application
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add identities
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $identities
     * @return Application
     */
    public function addIdentity(IdentityApplication $identities)
    {
        $this->identities[] = $identities;

        return $this;
    }

    /**
     * Remove identities
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $identities
     */
    public function removeIdentity(IdentityApplication $identities)
    {
        $this->identities->removeElement($identities);
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
}
