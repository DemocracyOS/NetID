<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Login log
 *
 * @ORM\Table(name="login_log")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class LoginLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Identity
     *
     * @ORM\ManyToOne(targetEntity="Identity")
     * @ORM\JoinColumn(name="identity_id", nullable=false)
     */
    private $identity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
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
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDate()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return LoginLog
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
     * @return LoginLog
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
     * @return LoginLog
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

    /**
     * Set identity
     *
     * @param \DeR\NetIdBundle\Entity\Identity $identity
     * @return LoginLog
     */
    public function setIdentity(\DeR\NetIdBundle\Entity\Identity $identity)
    {
        $this->identity = $identity;
    
        return $this;
    }

    /**
     * Get identity
     *
     * @return \DeR\NetIdBundle\Entity\Identity 
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}