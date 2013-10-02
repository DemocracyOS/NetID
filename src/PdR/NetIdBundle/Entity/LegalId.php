<?php

namespace PdR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * LegalId
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class LegalId
{
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="legalId")
     */
    private $users;

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
     * Set users
     *
     * @param string $name
     * @return LegalId
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }


    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->name;
    }
}
