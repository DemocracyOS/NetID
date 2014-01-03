<?php

namespace DemocracyOS\NetIdAdminBundle\Blocks;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

class AuditBlockService extends BaseBlockService
{
    protected $container;

    public function getName()
    {
        return 'Audit';
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
        $md5 = md5_file($this->container->getParameter('netid_log_path'));
        return $this->renderResponse('DemocracyOSNetIdAdminBundle:Blocks:block_audit.html.twig', array(
            'block'     => $block,
            'settings'  => $settings,
            'md5'       => $md5,
            'admin'     => $this->container->get('sonata.admin.identity')
            ), $response);
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }
}