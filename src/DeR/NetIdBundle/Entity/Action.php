<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Entity
 * @ORM\Table(name="action")
 */
class Action
{
    public function __construct($name = null)
    {
        $this->name = $name;
    }
    
    public function __toString()
    {
        return $this->name;
    }

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
     * @ORM\Column(nullable=false)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     */
    protected $role;

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
     * @return Role
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
     * Set role
     *
     * @param \DeR\NetIdBundle\Entity\Role $role
     * @return Action
     */
    public function setRole(\DeR\NetIdBundle\Entity\Role $role = null)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return \DeR\NetIdBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}