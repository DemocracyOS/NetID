<?php
namespace DemocracyOS\NetIdAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdentitySearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		->add('legalId', null, array('attr' => array('placeholder' => 'Legal Id'), 'label' => 'Legal Id'))
        		->add('email', 'email', array('attr' => array('placeholder' => 'Email'), 'label' => 'Email'))
        		->add('firstname', null, array('attr' => array('placeholder' => 'Firstname'), 'label' => 'Firstname'))
        		->add('lastname', null, array('attr' => array('placeholder' => 'Lastname'), 'label' => 'Lastname'))
        		->add('search', 'submit', array('attr' => array('class' => 'btn btn-primary'), 'label' => 'Search'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'DemocracyOS\NetIdAdminBundle\Entity\IdentitySearch',
	        'attr' => array('novalidate' => 'novalidate')
	    ));
	}

    public function getName()
    {
        return 'identity_search';
    }
}