<?php

namespace Alpixel\Bundle\UserBundle\Admin;

use Alpixel\Bundle\UserBundle\Entity\Admin as AdminEntity;
use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AdminAdmin extends Admin
{
    public function createQuery($context = 'list')
    {
        $container = $this->getConfigurationPool()->getContainer();
        $securityContext = $container->get('security.context');

        $query = parent::createQuery($context);

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'ID',
            ])
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'ID',
            ])
            ->addIdentifier('username', null, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->addIdentifier('firstname', null, [
                'label' => 'Prénom',
            ])
            ->addIdentifier('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('created', null, [
                'label' => 'Date de création',
            ])
            ->add('lastLogin', null, [
                'label' => 'Dernier login',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $securityContext = $container->get('security.context');

        $roles = [
            'ROLE_USER' => 'Simple utilisateur',
            'ROLE_ADMIN' => 'Administrateur',
        ];

        $formMapper
            ->with('Informations personnelles', [
                'description' => '',
                'class'       => 'col-md-8',
            ])
                ->add('username', null, [
                    'label' => 'Nom d\'utilisateur',
                ])
                ->add('email', null, [
                    'label' => 'Email',
                ])
                ->add('firstname', null, [
                    'label' => 'Prénom',
                ])
                ->add('lastname', null, [
                    'label' => 'Nom',
                ])
            ->end()
            ->with('Paramétrage', [
                'description' => '',
                'class'       => 'col-md-4',
            ])
                ->add('enabled', null, [
                    'label' => 'Compte actif',
                ])
                ->add('roles', 'choice', [
                    'multiple'  => true,
                    'choices'   => $roles,
                    'label'     => 'Permissions',
                ])
                ->add('plainPassword', 'text', [
                    'label'     => 'Changer le mot de passe',
                    'required'  => false,
                ])
            ->end();
    }

    public function preUpdate($user)
    {
        $this->getUserManager()->updateUser($user);
    }

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}
