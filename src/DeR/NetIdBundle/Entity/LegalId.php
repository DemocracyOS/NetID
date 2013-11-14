<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * LegalId
 *
 * @ORM\Table(name="legal_id")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class LegalId
{
    public function __construct()
    {
        $this->identities = new ArrayCollection();
    }

    /**
     * @var smallint
     *
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true, nullable=false)
     * @Expose
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Identity", mappedBy="legalIdType")
     */
    private $identities;

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
     * @return LegalId
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
     * Set identities
     *
     * @param string $name
     * @return LegalId
     */
    public function setIdentities($identities)
    {
        $this->identities = $identities;

        return $this;
    }

    /**
     * Get identities
     *
     * @return ArrayCollection
     */
    public function getIdentities()
    {
        return $this->identities;
    }

    public function __toString()
    {
        return $this->name;
    }
}
