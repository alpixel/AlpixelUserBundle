<?php

namespace Alpixel\Bundle\UserBundle\Provider;

use Cocur\Slugify\Slugify;
use FOS\UserBundle\Model\UserInterface as FOSUserInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Alpixel\Bundle\UserBundle\Event\UserEvent;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class OAuthUserProvider extends FOSUBUserProvider implements OAuthAwareUserProviderInterface
{

    protected $dispatcher;
    protected $request;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, array $properties, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($userManager, $properties);
        $this->dispatcher = $dispatcher;
    }

    public function setRequest(RequestStack $request_stack)
    {
        $this->request = $request_stack->getCurrentRequest();
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (UsernameNotFoundException $e) {
            $email = $response->getEmail();

            if (!empty($email)) {
                if (null === $user = $this->userManager->findUserByEmail($email)) {
                    return $this->createUserByOAuthUserResponse($response);
                }

                return $this->updateUserByOAuthUserResponse($user, $response);
            }
            throw new UsernameNotFoundException();
        }
    }
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $uniqueId = $response->getUsername();
        $user->addOAuthAccount($providerName, $uniqueId);
        $this->userManager->updateUser($user);
    }

    /**
     * Ad-hoc creation of user.
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    protected function createUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->createUser();
        $this->updateUserByOAuthUserResponse($user, $response);

        $data = $response->getResponse();

        $slugify  = new Slugify();
        $nickname = $slugify->slugify($data['first_name']);

        // set default values taken from OAuth sign-in provider account
        //$user->setBirthdate(new \DateTime($data['birthday']));
        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);

        if (null !== $email = $response->getEmail()) {
            $user->setEmail($email);
        }

        $originalNickname = $nickname;
        while (null !== $this->userManager->findUserByUsername($nickname)) {
            $nickname = $originalNickname.rand(0, 5000);
        }

        $user->setUsername($nickname);
        $user->setEnabled(true);

        $event = new UserEvent($user, $this->request);
        $this->dispatcher->dispatch("user.registration.done", $event);

        return $user;
    }

    /**
     * Attach OAuth sign-in provider account to existing user.
     *
     * @param FOSUserInterface      $user
     * @param UserResponseInterface $response
     *
     * @return FOSUserInterface
     */
    protected function updateUserByOAuthUserResponse(FOSUserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $providerNameSetter = 'set'.ucfirst($providerName).'Id';
        $user->$providerNameSetter($response->getUsername());
        if (!$user->getPassword()) {
            // generate unique token
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
        }

        return $user;
    }
}
