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

    /**
     * @var Identity
     *
     * @ORM\ManyToOne(targetEntity="Identity")
     */
    protected $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="performed_action", length=5)
     */
    protected $performedAction;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="LegalId")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     */
    protected $legalIdType;

    /**
     * @ORM\Column(name="legal_id", nullable=true)
     */
    protected $legalId;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="District")
     * @ORM\JoinColumn(name="district_id")
     */
    protected $district;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;

    public function __construct($identity = null)
    {
        $this->name = $identity->getName();
        $this->lastname = $identity->getLastname();
        $this->email = $identity->getEmail();
        $this->birthdate = $identity->getBirthdate();
        $this->legalIdT = $identity->getLegalIdType();
        $this->legalId = $identity->getLegalId();
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
     * @return IdentityLog
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
     * Set lastname
     *
     * @param string $lastname
     * @return IdentityLog
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return IdentityLog
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set legalId
     *
     * @param integer $legalId
     * @return IdentityLog
     */
    public function setLegalId($legalId)
    {
        $this->legalId = $legalId;
    
        return $this;
    }

    /**
     * Get legalId
     *
     * @return integer
     */
    public function getLegalId()
    {
        return $this->legalId;
    }

    /**
     * Set legalIdType
     *
     * @param integer $legalIdType
     * @return IdentityLog
     */
    public function setLegalIdType($legalIdType)
    {
        $this->legalIdType = $legalIdType;
    
        return $this;
    }

    /**
     * Get legalIdType
     *
     * @return LegalIdType
     */
    public function getLegalIdType()
    {
        return $this->legalIdType;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->date = new \DateTime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IdentityLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set district
     *
     * @param \DeR\NetIdBundle\Entity\District $district
     * @return IdentityLog
     */
    public function setDistrict(\DeR\NetIdBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return \DeR\NetIdBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
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
     * Set identity
     *
     * @param Identity $identity
     * @return IdentityLog
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    
        return $this;
    }

    /**
     * Get identity
     *
     * @return string 
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFullname()
    {
        return $this->name . ' ' . $this->lastname;
    }
}