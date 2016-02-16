<?php

namespace Alpixel\Bundle\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email', null, array(
                'label' => 'Email'
            ))
            ->add('enabled', null, array(
                'label' => 'Activé'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array(
                'label' => 'ID'
            ))
            ->add('email', null, array(
                'label' => 'Email'
            ))
            ->add('enabled', null, array(
                'label' => 'Activé'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array()
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array(
                'label' => 'ID'
            ))
            ->add('email', null, array(
                'label' => 'Email'
            ))
            ->add('enabled', null, array(
                'label' => 'Activé'
            ))
        ;
    }
}
