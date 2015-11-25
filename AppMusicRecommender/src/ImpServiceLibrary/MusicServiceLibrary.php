<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 24/11/15
 * Time: 21:41
 */
namespace ImpServiceLibrary;

use Infrastructure\MusicBuilderRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MusicServiceLibrary
{
    protected $container;
    protected $_musicBuilderRepository;

    /**
     * @InjectParams({
     *    "container" = @Inject("music.imp.service.library:")
     *    "_userBuilderRepository" = @Inject("music.impl.builder.repository")
     * })
     */
    function __construct(ContainerInterface $container, MusicBuilderRepository $musicBuilderRepository)
    {
        $this->container = $container;
        $this->_musicBuilderRepository = $musicBuilderRepository;

    }


}