<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
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
     * @ORM\ManyToMany(targetEntity="Action")
     */
    protected $actions;

    public function getActionNames()
    {
        $actions = array();
        foreach ($this->actions as $action) {
            $actions[] = $action->getName();
        }
        return $actions;
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
     * Constructor
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add actions
     *
     * @param \DeR\NetIdBundle\Entity\Action $actions
     * @return Role
     */
    public function addAction(\DeR\NetIdBundle\Entity\Action $actions)
    {
        $this->actions[] = $actions;
    
        return $this;
    }

    /**
     * Remove actions
     *
     * @param \DeR\NetIdBundle\Entity\Action $actions
     */
    public function removeAction(\DeR\NetIdBundle\Entity\Action $actions)
    {
        $this->actions->removeElement($actions);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActions()
    {
        return $this->actions;
    }
}