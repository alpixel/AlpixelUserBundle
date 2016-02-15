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
        $container       = $this->getConfigurationPool()->getContainer();
        $securityContext = $container->get('security.context');

        $query = parent::createQuery($context);

        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            $andx = $query->expr()->andx();

            $andx->add($query->expr()->notlike($query->getRootAlias().'.roles', ':nope'));
            $andx->add($query->expr()->notlike($query->getRootAlias().'.roles', ':nope2'));

            $query->andWhere($andx);
            $query->setParameter('nope', '%ROLE_ADMIN%');
            $query->setParameter('nope2', '%ROLE_SUPER_ADMIN%');
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array(
                'label' => 'ID',
            ))
            ->add('username', null, array(
                'label' => 'Nom d\'utilisateur',
            ))
            ->add('firstname', null, array(
                'label' => 'Prénom',
            ))
            ->add('lastname', null, array(
                'label' => 'Nom',
            ))
            ->add('email', null, array(
                'label' => 'Email',
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array(
                'label' => 'ID',
            ))
            ->addIdentifier('username', null, array(
                'label' => 'Nom d\'utilisateur',
            ))
            ->addIdentifier('firstname', null, array(
                'label' => 'Prénom',
            ))
            ->addIdentifier('lastname', null, array(
                'label' => 'Nom',
            ))
            ->add('email', null, array(
                'label' => 'Email',
            ))
            ->add('created', null, array(
                'label' => 'Date de création',
            ))
            ->add('lastLogin', null, array(
                'label' => 'Dernier login',
            ))
            ->add('roles', null, array(
                'label'     => 'Permissions',
                'template'  => 'UserBundle:admin:fields/list_roles.html.twig',
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container       = $this->getConfigurationPool()->getContainer();
        $securityContext = $container->get('security.context');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $roles = array(
                'ROLE_USER'             => AdminEntity::getRoleString('ROLE_USER'),
                'ROLE_MODERATOR'        => AdminEntity::getRoleString('ROLE_MODERATOR'),
                'ROLE_MODERATOR_LEADER' => AdminEntity::getRoleString('ROLE_MODERATOR_LEADER'),
                'ROLE_SUPER_ADMIN'      => AdminEntity::getRoleString('ROLE_SUPER_ADMIN'),
            );
        } else {
            $roles = array(
                'ROLE_USER'             => AdminEntity::getRoleString('ROLE_USER'),
                'ROLE_MODERATOR'        => AdminEntity::getRoleString('ROLE_MODERATOR'),
            );
        }
        $formMapper
            ->with('Informations personnelles', array(
                'description' => '',
                'class'       => 'col-md-8',
            ))
                ->add('username', null, array(
                    'label' => 'Nom d\'utilisateur',
                ))
                ->add('email', null, array(
                    'label' => 'Email',
                ))
                ->add('firstname', null, array(
                    'label' => 'Prénom',
                ))
                ->add('lastname', null, array(
                    'label' => 'Nom',
                ))
            ->end()
            ->with('Paramétrage', array(
                'description' => '',
                'class'       => 'col-md-4',
            ))
                ->add('enabled', null, array(
                    'label' => 'Compte actif',
                ))
                ->add('roles', 'choice', array(
                    'multiple'  => true,
                    'choices'   => $roles,
                    'label'     => 'Permissions',
                ))
                ->add('plainPassword', 'text', array(
                    'label'     => 'Changer le mot de passe',
                    'required'  => false,
                ))
            ->end()
        ;
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
