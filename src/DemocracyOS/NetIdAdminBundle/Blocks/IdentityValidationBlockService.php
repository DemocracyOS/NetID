<?php

namespace DemocracyOS\NetIdAdminBundle\Blocks;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

class IdentityValidationBlockService extends BaseBlockService
{
    protected $container;

    public function getName()
    {
        return 'Identity Validation';
    }

    public function getDefaultSettings()
    {
        return array();
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    public function execute(BlockContextInterface $block, Response $response = null)
    {
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());
        return $this->renderResponse('DemocracyOSNetIdAdminBundle:Blocks:block_identity_validation.html.twig', array(
            'block'     => $block,
            'settings'  => $settings,
            'admin'     => $this->container->get('sonata.admin.identity')
            ), $response);
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }
}