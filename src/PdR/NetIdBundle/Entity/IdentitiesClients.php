<?php

namespace PdR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * IdentitiesClient
 *
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class IdentitiesClients
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Identity", inversedBy="clients")
     * @ORM\Id
     * @ORM\JoinColumn(name="identity_id")
     */
    private $identity;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="identities")
     * @ORM\Id
     * @ORM\JoinColumn(name="client_id")
     * @Expose
     * @Type("string")
     * @SerializedName("appId")
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column
     * @Type("string")
     * @Expose
     */
    private $foreignId;


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
     * Set identity
     *
     * @param \PdR\NetIdBundle\Entity\Identity $identity
     * @return IdentitiesClient
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    
        return $this;
    }

    /**
     * Get identity
     *
     * @return \PdR\NetIdBundle\Entity\Identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set client
     *
     * @param \PdR\NetIdBundle\Entity\Client $client
     * @return IdentitiesClient
     */
    public function setClient($client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \PdR\NetIdBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set foreignId
     *
     * @param string $foreignId
     * @return IdentitiesClient
     */
    public function setForeignId($foreignId)
    {
        $this->foreignId = $foreignId;
    
        return $this;
    }

    /**
     * Get foreignId
     *
     * @return string 
     */
    public function getForeignId()
    {
        return $this->foreignId;
    }
}
