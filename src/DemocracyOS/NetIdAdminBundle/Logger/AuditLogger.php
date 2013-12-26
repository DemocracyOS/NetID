<?php

namespace DemocracyOS\NetIdAdminBundle\Logger;

class AuditLogger
{
	protected $auditLogger;
	protected $securityContext;
	protected $request;

	public function __construct($auditLogger, $securityContext, $container)
	{
		$this->auditLogger = $auditLogger;
		$this->securityContext = $securityContext;
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
		if (!isset($subject))
		{
			$subject = $this->securityContext->getToken()->getUser();
		}
		
		if (!isset($context))
		{
			$server = $this->request->server;
			$userAgent = $server->get('HTTP_USER_AGENT');
			$ip = $server->get('REMOTE_ADDR');
			$context = array($userAgent, $ip);
		}

		$message = sprintf('%s %s', $subject, $action);

		if (isset($object))
		{
			$message .= sprintf(' %s %s', $this->parse_classname(get_class($object)), $object);
		}

		$this->auditLogger->info($message, $context);
	}

	protected function parse_classname($name)
	{
	  return join('', array_slice(explode('\\', $name), -1));
	}
}