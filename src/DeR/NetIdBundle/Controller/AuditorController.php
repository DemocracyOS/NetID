<?php

namespace DeR\NetIdBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

class AuditorController extends CRUDController
{
    public function listAction()
    {
    	if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        $req = $this->getRequest();
        $req->request->set('format', 'csv');
        $response = parent::exportAction($this->get('request'));
        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        $md5Csv = md5($content);

        return $this->render('DeRNetIdBundle:Default:identity_log_list.html.twig', array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'md5Csv'     => $md5Csv,
        ));
    }
}