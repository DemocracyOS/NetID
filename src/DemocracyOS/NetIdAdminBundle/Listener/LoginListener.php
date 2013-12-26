<?php

namespace DemocracyOS\NetIdAdminBundle\Listener;
 
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
 
/**
 * Custom login listener.
 */
class LoginListener
{
	protected $auditLogger;
	
	/**
	 * Constructor
	 * 
	 * @param \DemocracyOS\NetIdAdminBundle\Logger\AuditLogger $auditLogger
	 */
	public function __construct($auditLogger)
	{
		$this->auditLogger = $auditLogger;
	}
	
	/**
	 * Log login action.
	 * 
	 * @param InteractiveLoginEvent $event
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
		$this->auditLogger->login();
	}
}