<?php

namespace PdR\NetIdBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use PdR\NetIdBundle\Entity\User;

class UserAdminController extends CRUDController
{
	public function suspiciousAction($id)
	{
		$object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->setSubject($object);

        $csrfToken = $this->getCsrfToken('suspicious');

		return $this->render('PdRNetIdBundle:UserAdmin:suspicious.html.twig', array('object' => $object, 'action' => 'suspicious', 'csrf_token' => $csrfToken));
	}

	public function markSuspiciousAction($id)
	{
		$object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setSuspicious();

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($object);
        $em->flush();

    	$this->addFlash('sonata_flash_success', 'flash_mark_suspicious_success');
        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
	}
}