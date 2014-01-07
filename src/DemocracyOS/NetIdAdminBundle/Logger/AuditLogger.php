<?php

namespace DemocracyOS\NetIdAdminBundle\Logger;

use DemocracyOS\NetIdAdminBundle\Document\LogRecord;

class AuditLogger
{
	protected $securityContext;
	protected $request;
	protected $em;

	public function __construct($securityContext, $container)
	{
		$this->securityContext = $securityContext;
		$this->em = $container->get('doctrine_mongodb')->getManager();
		if ($container->isScopeActive('request')) {
			$this->request = $container->get('request');
		}
	}

	public function login()
	{
		$this->log('logged in');
	}

	public function create($object)
	{
		$this->log('created', $object);
	}

	public function edit($object)
	{
		$this->log('edited', $object);
	}

	public function delete($object)
	{
		$this->log('deleted', $object);
	}

	public function validate($object)
	{
		$this->log('validated', $object);
	}

	public function invalidate($object)
	{
		$this->log('invalidated', $object);
	}

	public function markSuspicious($object)
	{
		$this->log('marked as suspicious', $object);
	}

	public function unmarkSuspicious($object)
	{
		$this->log('unmarked as suspicious', $object);
	}

	public function exportLog()
	{
		$this->log('exported log');
	}

	public function log($action, $object = null)
	{
		$subject = $this->securityContext->getToken()->getUser();
		
		$server = $this->request->server;
		$browserData = $server->get('HTTP_USER_AGENT');
		$ip = $server->get('REMOTE_ADDR');

		$logRecord = new LogRecord();
		$logRecord->setIp($ip);
		$logRecord->setBrowserData($browserData);
		$logRecord->setRoles($subject->getRoles());
		$logRecord->setAction($action);
		$logRecord->setUsername($subject->getUsername());
		$logRecord->setObject((string) $object);

		$this->em->persist($logRecord);
		$this->em->flush();

		if (isset($object))
		{

		}

		#$this->auditLogger->info($message, $context);
	}
}