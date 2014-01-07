<?php

namespace DemocracyOS\NetIdAdminBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\Document */
class LogRecord
{
	/** @MongoDB\Id */
	protected $id;

	/** @MongoDB\String */
	protected $ip;

	/** @MongoDB\String */
	protected $browserData;

	/** @MongoDB\Hash */
	protected $roles;

	/** @MongoDB\String */
	protected $username;

    /** @MongoDB\String */
	protected $action;

    /** @MongoDB\String */
	protected $object;

    /** @MongoDB\Date */
	protected $datetime;

    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get ip
     *
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set browserData
     *
     * @param string $browserData
     * @return self
     */
    public function setBrowserData($browserData)
    {
        $this->browserData = $browserData;
        return $this;
    }

    /**
     * Get browserData
     *
     * @return string $browserData
     */
    public function getBrowserData()
    {
        return $this->browserData;
    }

    /**
     * Set roles
     *
     * @param hash $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get roles
     *
     * @return hash $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set datetime
     *
     * @param date $datetime
     * @return self
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * Get datetime
     *
     * @return date $datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Get action
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get roles list
     *
     * @return string $rolesList
     */
    public function getRolesList()
    {
        return implode(", ", $this->roles);
    }

    /**
     * Set object
     *
     * @param string $object
     * @return self
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Get object
     *
     * @return string $object
     */
    public function getObject()
    {
        return $this->object;
    }
}
