<?php
namespace DeR\NetIdBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdentitySearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		->add('legalId', null, array('attr' => array('placeholder' => 'legal.id'), 'label' => 'legal.id'))
        		->add('email', 'email', array('attr' => array('placeholder' => 'email'), 'label' => 'email'))
        		->add('firstname', null, array('attr' => array('placeholder' => 'firstname'), 'label' => 'firstname'))
        		->add('lastname', null, array('attr' => array('placeholder' => 'lastname'), 'label' => 'lastname'))
        		->add('search', 'submit', array('attr' => array('class' => 'btn'), 'label' => 'search'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'DeR\NetIdBundle\Entity\IdentitySearch',
	        'attr' => array('novalidate' => 'novalidate')
	    ));
	}

    public function getName()
    {
        return 'identity_search';
    }
}