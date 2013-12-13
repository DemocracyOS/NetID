<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Identity
 *
 * @ORM\Entity
 * @ORM\Table(name="identity")
 */
class Identity
{
    public function __toString()
    {
        if (isset($this->id))
        {
            return $this->getFullname();
        } else {
            return 'New Identity';
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
}
