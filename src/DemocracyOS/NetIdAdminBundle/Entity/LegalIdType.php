<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LegalIdType
 *
 * @ORM\Entity
 * @ORM\Table(name="legal_id_type")
 */
class LegalIdType
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Identity", mappedBy="legalIdType")
     */
    private $identities;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * ToString method
     */
    public function __toString()
    {
        return $this->name;
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
     * @return LegalIdType
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
     * Add identities
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Identity $identities
     * @return LegalIdType
     */
    public function addIdentity(\DemocracyOS\NetIdAdminBundle\Entity\Identity $identities)
    {
        $this->identities[] = $identities;

        return $this;
    }

    /**
     * Remove identities
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Identity $identities
     */
    public function removeIdentity(\DemocracyOS\NetIdAdminBundle\Entity\Identity $identities)
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
