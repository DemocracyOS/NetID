<?php

namespace DeR\NetIdBundle\Blocks;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

class IdentityValidationBlockService extends BaseBlockService
{
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
        // merge settings
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());

        return $this->renderResponse('DeRNetIdBundle:Blocks:block_identity_validation.html.twig', array(
            'block'     => $block,
            'settings'  => $settings
            ), $response);
    }
}