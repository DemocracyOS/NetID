<?php

namespace DeR\NetIdBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use DeR\NetIdBundle\Entity\Identity;
use DeR\NetIdBundle\Entity\IdentitySearch;
use DeR\NetIdBundle\Type\IdentitySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IdentityAdminController extends CRUDController
{
    protected $id;
    protected $identity;

	public function suspiciousAction($id)
	{
        $this->id = $id;
        return $this->suspiciousyAction('DeRNetIdBundle:IdentityAdmin:suspicious.html.twig', 'suspicious');
	}

    public function unsuspiciousAction($id)
    {
        $this->id = $id;
        return $this->suspiciousyAction('DeRNetIdBundle:IdentityAdmin:unsuspicious.html.twig', 'unsuspicious');
    }

    protected function suspiciousyAction($template, $action)
    {
        $securityContext = $this->get('security.context');
        if (!$securityContext->isGranted('ROLE_ADMIN') || !$securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }
        $object = $this->admin->getObject($this->id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->setSubject($object);

        $csrfToken = $this->getCsrfToken('suspicious');

        return $this->render($template, array('object' => $object, 'action' => $action, 'csrf_token' => $csrfToken));   
    }

	public function markSuspiciousAction($id)
	{
		$this->id = $id;
        return $this->markSuspiciousy(true, 'flash_mark_suspicious_success');
	}

    public function markUnsuspiciousAction($id)
    {
        $this->id = $id;
        return $this->markSuspiciousy(false, 'flash_mark_unsuspicious_success');
    }

    protected function markSuspiciousy($isSuspicious, $flashMessage)
    {
        $securityContext = $this->get('security.context');
        if (!$securityContext->isGranted('ROLE_ADMIN') || !$securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getObject($this->id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setSuspicious($isSuspicious);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($object);
        $em->flush();

        $this->addFlash('sonata_flash_success', $flashMessage);
        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
    }

    /**
     * {@inheritdoc}
     */
    public function listAction()
    {
        $render = parent::listAction();
        $this->admin->logIdentity(null, 'LIST');
        return $render;
    }

    public function exportAction(Request $request)
    {
        $response = parent::exportAction($request);
        $this->admin->logIdentity(null, 'EXP');
        return $response;
    }

    public function identityValidateSearchAction()
    {
        $form = $this->createForm(new IdentitySearchType(), new IdentitySearch());
        return $this->render('DeRNetIdBundle:IdentityAdmin:validate.html.twig', 
            array('action'      =>  'validate',
                'form'          =>  $form->createView(),
                'identities'    =>  array()));
    }

    public function identityValidateSearchPostAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('DeRNetIdBundle:Identity');
        $identitySearch = new IdentitySearch();
        $form = $this->createForm(new IdentitySearchType(), $identitySearch);
        $form->bind($request);
        $identities = $repository->search($identitySearch);
        return $this->render('DeRNetIdBundle:IdentityAdmin:validate.html.twig', array('action' => 'validate', 'identities' => $identities, 'form' => $form->createView()));
    }

    public function validateIdentityAction($id)
    {
        $this->id = $id;
        $this->findIdentity();
        
        if ($this->identity->isValidated())
        {
            throw new AccessDeniedException(sprintf('Identity is already validated.'));
        }

        $this->identity->validate();
        $this->persistIdentity();
        $this->admin->logIdentity($this->identity, 'VAL');

        $this->addFlash('sonata_flash_success', 'flash_validate_identity_success');
        return $this->redirect($this->admin->generateUrl('identityValidateSearch'));
    }

    public function invalidateIdentityAction($id)
    {
        $this->id = $id;
        $this->findIdentity();
        
        if (!$this->identity->isValidated())
        {
            throw new AccessDeniedException(sprintf('Identity is already invalidated.'));
        }

        $this->identity->invalidate();
        $this->persistIdentity();
        $this->admin->logIdentity($this->identity, 'INVAL');

        $this->addFlash('sonata_flash_success', 'flash_invalidate_identity_success');
        return $this->redirect($this->admin->generateUrl('identityValidateSearch'));
    }

    protected function persistIdentity()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($this->identity);
        $em->flush();
    }

    protected function findIdentity()
    {
        $repository = $this->getDoctrine()->getRepository('DeRNetIdBundle:Identity');
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
}