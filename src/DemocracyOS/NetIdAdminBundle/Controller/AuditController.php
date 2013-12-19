<?php

namespace DemocracyOS\NetIdAdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

class AuditController extends CRUDController
{
    public function downloadLogAction()
    {
        $path = $this->container->getParameter('netid_log_path');
        $content = file_get_contents($path);

        $filename = 'log.json';
        
        $response = new Response();

        $response->headers->set('Content-Type', 'json');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);
        $auditLogger = $this->container->get('audit_logger');
        $auditLogger->log('exported log');
        return $response;
    }
}