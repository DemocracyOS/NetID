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

        $md5Csv = $this->getMd5('csv');
        $md5Xls = $this->getMd5('xls');
        $md5s = array();
        $md5s['csv'] = $md5Csv;
        $md5s['xls'] = $md5Xls;

        return $this->render('DeRNetIdBundle:Default:identity_log_list.html.twig', array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'md5s'     => $md5s,
        ));
    }

    protected function getMd5($format)
    {
        $req = $this->getRequest();
        $req->request->set('format', $format);
        $response = parent::exportAction($this->get('request'));
        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        $md5 = md5($content);
        return $md5;
    }
}