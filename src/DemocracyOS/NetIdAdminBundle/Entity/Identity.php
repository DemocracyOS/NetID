<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication;
use DemocracyOS\NetIdAdminBundle\Entity\Email;

/**
 * Identity
 *
 * @ORM\Table(name="identity")
 * @ORM\Entity(repositoryClass="DemocracyOS\NetIdAdminBundle\Repository\IdentityRepository")
 */
class Identity
{
    public function __toString()
    {
        if (isset($this->id))
        {
            return sprintf('#%s - %s', $this->id, $this->getFullname());
        } else {
            return 'New Identity';
        }
    }

    public function __construct($email = null)
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        if ($email)
        {
            $this->addEmail(new Email($email));
        }
    }

    public function getFullname()
    {
        return sprintf('%s %s', $this->firstname, $this->lastname);
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
     * @ORM\Column()
     * @Assert\NotBlank(message = "The firstname should not be blank")
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column()
     * @Assert\NotBlank(message = "The lastname should not be blank")
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Email", mappedBy="identity", cascade={"all"}, orphanRemoval=true)
     */
    protected $emails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\ManyToOne(targetEntity="LegalIdType", inversedBy="identities")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     */
    protected $legalIdType;

    /**
     * @ORM\Column(name="legal_id", nullable=true)
     */
    protected $legalId;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="identities")
     * @ORM\JoinColumn(name="district_id")
     */
    protected $district;

    /**
     * @ORM\OneToMany(targetEntity="IdentityApplication", mappedBy="identity", cascade={"all"}, orphanRemoval=true)
     */
    private $applications;

    /**
     * @var validated
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $validated = false;

    /**
     * @var suspicious
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $suspicious = false;

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
     * Set firstname
     *
     * @param string $firstname
     * @return Identity
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Identity
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Identity
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }
    
    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set legalIdType
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\LegalIdType $legalIdType
     * @return Identity
     */
    public function setLegalIdType(\DemocracyOS\NetIdAdminBundle\Entity\LegalIdType $legalIdType = null)
    {
        $this->legalIdType = $legalIdType;

        return $this;
    }

    /**
     * Get legalIdType
     *
     * @return \DemocracyOS\NetIdAdminBundle\Entity\LegalIdType 
     */
    public function getLegalIdType()
    {
        return $this->legalIdType;
    }

    /**
     * Set legalId
     *
     * @param string $legalId
     * @return Identity
     */
    public function setLegalId($legalId)
    {
        $this->legalId = $legalId;

        return $this;
    }

    /**
     * Get legalId
     *
     * @return string 
     */
    public function getLegalId()
    {
        return $this->legalId;
    }

    /**
     * Set district
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\District $district
     * @return Identity
     */
    public function setDistrict(\DemocracyOS\NetIdAdminBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \DemocracyOS\NetIdAdminBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add applications
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $applications
     * @return Identity
     */
    public function addApplication(\DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $applications)
    {
        $this->applications[] = $applications;

        return $this;
    }

    /**
     * Remove applications
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $applications
     */
    public function removeApplication(\DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Is validated
     *
     * @return boolean 
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Identity
     */
    public function setValidated($validated = true)
    {
        $this->validated = $validated;
    
        return $this;
    }

    /**
     * Is suspicious
     *
     * @return boolean 
     */
    public function isSuspicious()
    {
        return $this->suspicious;
    }

    /**
     * Set suspicious
     *
     * @param boolean $suspicious
     * @return Identity
     */
    public function setSuspicious($suspicious = true)
    {
        $this->suspicious = $suspicious;
    
        return $this;
    }

    /**
     * Clear applications
     *
     * @return Identity
     */
    public function clearApplications()
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();

        return $this;
    }

    public function getRowStatus()
    {
        if ($this->isValidated())
        {
            return 'success';
        } elseif ($this->isSuspicious()) {
            return 'error';
        }
        return 'info';
    }

    public function isValidatable()
    {
        return !$this->isSuspicious() && !$this->validated;
    }

    public function isInvalidatable()
    {
        return !$this->isSuspicious() && $this->validated;
    }

    public function validate()
    {
        $this->setValidated(true);
    }

    public function invalidate()
    {
        $this->setValidated(false);
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Get suspicious
     *
     * @return boolean 
     */
    public function getSuspicious()
    {
        return $this->suspicious;
    }

    /**
     * Add emails
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Email $emails
     * @return Identity
     */
    public function addEmail(\DemocracyOS\NetIdAdminBundle\Entity\Email $email)
    {
        $this->emails[] = $email;
        $email->setIdentity($this);

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Email $emails
     */
    public function removeEmail(\DemocracyOS\NetIdAdminBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
