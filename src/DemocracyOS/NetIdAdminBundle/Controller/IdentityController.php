<?php

namespace DemocracyOS\NetIdAdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use DemocracyOS\NetIdAdminBundle\Entity\Identity;
use DemocracyOS\NetIdAdminBundle\Entity\IdentitySearch;
use DemocracyOS\NetIdAdminBundle\Form\IdentitySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IdentityController extends CRUDController
{
    public function identityValidateSearchAction()
    {
        $form = $this->createForm(new IdentitySearchType(), new IdentitySearch());
        $exceeded = false;
        return $this->render('DemocracyOSNetIdAdminBundle:Identity:validate.html.twig', 
            array('action'      =>  'validate',
                'form'          =>  $form->createView(),
                'identities'    =>  array(),
                'exceeded'      =>  $exceeded));
    }

    public function identityValidateSearchPostAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $identitySearch = new IdentitySearch();
        $form = $this->createForm(new IdentitySearchType(), $identitySearch);
        $form->bind($request);
        $identities = $repository->search($identitySearch);
        $searchLimit = $this->container->getParameter('identity.validation.search.limit');
        $exceeded = count($identities) > $searchLimit;
        return $this->render('DemocracyOSNetIdAdminBundle:Identity:validate.html.twig', 
            array('action' => 'validate',
                'identities' => $identities, 
                'form' => $form->createView(),
                'exceeded' => $exceeded));
    }
}