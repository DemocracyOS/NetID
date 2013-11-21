<?php
namespace DeR\NetIdBundle\Twig;

class IdentityLogExtension extends \Twig_Extension
{
    protected $translator;
    protected $em;

    public function __construct($translator, $em)
    {
        $this->translator = $translator;
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('identitylog', array($this, 'logFilter')),
        );
    }

    public function logFilter($identityLog)
    {
        $action = sprintf("[%s] - ", $identityLog->getDate()->format('d/m/Y H:i:s'));
        $action .= $identityLog->getSubject();
        $action .= ' ' . $this->translator->trans($identityLog->getPerformedAction());

        if (in_array($identityLog->getPerformedAction(), array('INS', 'UPD', 'DEL'))) {
            $filters = $this->em->getFilters();
            $filters->disable('softdeleteable');
            $action .= ' ' . $identityLog->getObject();
            $filters->enable('softdeleteable');
        }

        return $action;
    }

    public function getName()
    {
        return 'identity_log_extension';
    }
}