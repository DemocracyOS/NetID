<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identity Log
 *
 * This class is used to log every action performed to an identity
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="identity_log")
 */
class IdentityLog
{
    public function __toString()
    {
        return $this->identity->getUsername() . ' ' . $this->performedAction . ' on ' . $this->getFullname();
    }

    public function __construct($subject, $performedAction, $object = null)
    {
        $this->subject = $subject;
        $this->performedAction = $performedAction;
        $this->object = $object;
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
     * @var Identity
     *
     * @ORM\ManyToOne(targetEntity="Identity")
     * @ORM\JoinColumn(name="subject_id")
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="performed_action", length=5)
     */
    protected $performedAction;

    /**
     * @var Identity
     *
     * @ORM\ManyToOne(targetEntity="Identity")
     * @ORM\JoinColumn(name="object_id")
     */
    protected $object;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var \String
     *
     * @ORM\Column(nullable=false)
     */
    protected $ip;

    /**
     * @var \String
     *
     * @ORM\Column(name="user_agent", nullable=false)
     */
    protected $userAgent;

    /**
     * @var \Array
     *
     * @ORM\Column(type="array")
     */
    protected $roles;

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
     * Set performedAction
     *
     * @param string $performedAction
     * @return IdentityLog
     */
    public function setPerformedAction($performedAction)
    {
        $this->performedAction = $performedAction;
    
        return $this;
    }

    /**
     * Get performedAction
     *
     * @return string 
     */
    public function getPerformedAction()
    {
        return $this->performedAction;
    }

    /**
     * Set subject
     *
     * @param \DeR\NetIdBundle\Entity\Identity $subject
     * @return IdentityLog
     */
    public function setSubject(\DeR\NetIdBundle\Entity\Identity $subject = null)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return \DeR\NetIdBundle\Entity\Identity 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set object
     *
     * @param \DeR\NetIdBundle\Entity\Identity $object
     * @return IdentityLog
     */
    public function setObject(\DeR\NetIdBundle\Entity\Identity $object = null)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return \DeR\NetIdBundle\Entity\Identity 
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDate()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return IdentityLog
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     * @return IdentityLog
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    
        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string 
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return IdentityLog
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    
        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}