<?php

namespace Alpixel\Bundle\UserBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AdminAdmin extends AbstractAdmin
{
    protected $userManager;

    public function createQuery($context = 'list')
    {
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
            ])
            ->add('created', null, [
                'label' => 'Date de création',
            ])
            ->add('lastLogin', null, [
                'label' => 'Dernier login',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => [],
                ],
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $optionsRoles = [
            'multiple'  => true,
            'label'     => 'Permissions',
        ];

        if (\AppKernel::VERSION_ID >= 20700) {
            $optionsRoles['choices'] = array_flip($container->getParameter('alpixel_user.role_descriptions'));

            if (\AppKernel::VERSION_ID < 30000) {
                $optionsRoles['choices_as_values'] = true;
            }
        } else {
            $optionsRoles['choices'] = $container->getParameter('alpixel_user.role_descriptions');
        }

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
                ->add('roles', 'choice', $optionsRoles)
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
