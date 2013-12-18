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
    protected $id;

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

    public function validateIdentityAction($id)
    {
        $this->id = $id;
        return $this->renderValidateIdentity('validate');
    }

    public function invalidateIdentityAction($id)
    {
        $this->id = $id;
        return $this->renderValidateIdentity('invalidate');
    }

    protected function renderValidateIdentity($action)
    {
        $this->findIdentity();
        $csrfToken = $this->getCsrfToken('suspicious');
        return $this->render('DemocracyOSNetIdAdminBundle:Identity:confirmValidate.html.twig', array('identity' => $this->identity, 'action' => $action, 'csrf_token' => $csrfToken));
    }

    public function validateIdentityPostAction($id)
    {
        $this->id = $id;
        $this->findIdentity();

        $this->identity->validate();
        $this->persistIdentity();

        $this->addFlash('sonata_flash_success', 'Identity successfully invalidated');
        return $this->redirect($this->admin->generateUrl('identityValidateSearch'));
    }

    public function invalidateIdentityPostAction($id)
    {
        $this->id = $id;
        $this->findIdentity();

        $this->identity->invalidate();
        $this->persistIdentity();

        $this->addFlash('sonata_flash_success', 'Identity successfully validated');
        return $this->redirect($this->admin->generateUrl('identityValidateSearch'));
    }

    protected function findIdentity()
    {
        $repository = $this->getDoctrine()->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $this->identity = $repository->find($this->id);
        if (!$this->identity)
        {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        if ($this->identity->isSuspicious())
        {
            throw new AccessDeniedException(sprintf('Identity is suspicious. Cannot be validated.'));
        }
    }

    protected function persistIdentity()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($this->identity);
        $em->flush();
    }
}