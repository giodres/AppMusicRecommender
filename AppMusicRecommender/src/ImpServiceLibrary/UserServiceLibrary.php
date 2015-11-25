<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 24/11/15
 * Time: 21:41
 */
namespace ImpServiceLibrary;

use AppBundle\Entity\User;
use Infrastructure\UserBuilderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserServiceLibrary
{
    protected $container;
    protected $_userBuilderRepository;

    /**
     * @InjectParams({
     *    "container" = @Inject("imp.service.library")
     *    "_userBuilderRepository" = @Inject("impl.builder.repository")
     * })
     */
    function __construct(ContainerInterface $container, UserBuilderRepository $userBuilderRepository)
    {
        $this->container = $container;
        $this->_userBuilderRepository = $userBuilderRepository;

    }

    public function getInstanceUser() {
        return new User();
    }

    public function createNewUser($user) {
        $password = $this->container->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        return $this->_userBuilderRepository->buildUser($user);
    }




}