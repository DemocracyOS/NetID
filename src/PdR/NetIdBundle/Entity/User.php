<?php

namespace PdR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\MaxDepth;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * User
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @Assert\Callback(methods={"isClientsValid"})
 * @UniqueEntity(fields="email", message="user.email.duplicated")
 */
class User extends BaseUser
{
    public function __construct()
    {
        $this->clients = new ArrayCollection();
        parent::__construct();
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "user.name.not_blank")
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "user.lastname.not_blank")
     * @Expose
     */
    protected $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="user.birthdate.invalid")
     * @Expose
     * @Type("DateTime<'Y-m-d'>")
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="LegalId", inversedBy="users")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     * @Expose
     * @MaxDepth(1)
     * @Type("string")
     */
    protected $legalIdType;

    /**
     * @ORM\Column(name="legal_id", nullable=true)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="user.legal_id.invalid"
     * )
     */
    protected $legalId;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $staff = false;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="users")
     * @ORM\JoinColumn(name="district_id")
     * @Expose
     * @Type("string")
     */
    protected $district;

    /**
     * @ORM\OneToMany(targetEntity="UsersClients", mappedBy="user", cascade="all", orphanRemoval=true)
     * @Expose
     */
    protected $clients;

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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set staff
     *
     * @param boolean $staff
     * @return User
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    
        return $this;
    }

    /**
     * Get staff
     *
     * @return boolean 
     */
    public function getStaff()
    {
        return $this->staff;
    }

    public function getRoles()
    {
        $roles = parent::getRoles();
        if ($this->staff)
        {
            $roles[] = 'ROLE_ADMIN';
        }
        return $roles;
    }

    /**
     * Set district
     *
     * @param \PdR\NetIdBundle\Entity\District $district
     * @return User
     */
    public function setDistrict(\PdR\NetIdBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return \PdR\NetIdBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    
    /**
     * Add clients
     *
     * @param \PdR\NetIdBundle\Entity\UsersClients $clients
     * @return Client
     */
    public function addClient(\PdR\NetIdBundle\Entity\UsersClients $clients)
    {
        $this->clients[] = $clients;
    
        return $this;
    }

    /**
     * Remove clients
     *
     * @param \PdR\NetIdBundle\Entity\UsersClients $clients
     */
    public function removeClient(\PdR\NetIdBundle\Entity\UsersClients $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    public function clearClients()
    {
        $this->clients = new ArrayCollection();
    }

    public function isClientsValid(\Symfony\Component\Validator\ExecutionContextInterface $context)
    {
        $clients = array();
        foreach ($this->clients as $client) {
            if (!in_array($client->getClient(), $clients))
            {
                $clients[] = $client->getClient();
            } else {
                $context->addViolationAt('clients', 'user.client.duplicated', array(), null);
                return;
            }
        }
    }

    public function setEmail($email)
    {
        $this->username = $email;
        parent::setEmail($email);
    }

    protected function hasLegalId()
    {
        return isset($this->legalId);
    }

    public function isAllowed($verb)
    {
        return $this->hasLegalId();
    }
}