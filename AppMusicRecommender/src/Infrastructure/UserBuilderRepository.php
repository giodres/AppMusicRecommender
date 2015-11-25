<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 24/11/15
 * Time: 21:44
 */

namespace Infrastructure;

use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\EntityManager;

class UserBuilderRepository
{
    protected $doctrine;

    /**
     * @InjectParams({
     *    "doctrine" = @Inject("doctrine.orm.entity_manage")
     * })
     */
    function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildUser($user)
    {
        try {
            //$doctrine = $this->getDoctrine()->getManager();
            $this->doctrine->persist($user);
            $this->doctrine->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}