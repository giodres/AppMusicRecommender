<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 24/11/15
 * Time: 21:44
 */

namespace Infrastructure;


use Doctrine\ORM\EntityManager;

class MusicBuilderRepository
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



}