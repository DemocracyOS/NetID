<?php

namespace DeR\NetIdBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use DeR\NetIdBundle\Entity\Identity;

class IdentityAdminController extends CRUDController
{
    protected $id;

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
}