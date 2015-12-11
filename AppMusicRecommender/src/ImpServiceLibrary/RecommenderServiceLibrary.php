<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 1/12/15
 * Time: 19:49
 */

namespace ImpServiceLibrary;


use Infrastructure\RecommenderBuilderRepository;
use Library\MusicRepository;
use Library\RecommenderRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RecommenderServiceLibrary
{
    protected $_musicBuilderRepository;
    protected $_recommenderBuilderRepository;
    protected $container;

    /**
     * @InjectParams({
     *    "_musicLibraryRepository" = @Inject("music.Library.repository")
     *    "container" = @Inject("imp.service.library")
     *    "_recommenderBuilderRepository" = @Inject("recommender.impl.builder.repository")
     * })
     */
    function __construct(MusicRepository $musicLibraryRepository, ContainerInterface $container, RecommenderBuilderRepository $recommenderRepository)
    {
        $this->_musicLibraryRepository = $musicLibraryRepository;
        $this->container = $container;
        $this->_recommenderBuilderRepository = $recommenderRepository;
    }

    public function example()
    {
        return 1;
    }

    public function getRecomenderBySinger($user)
    {
        return $this->_recommenderBuilderRepository->getRecomenderBySinger($user);
    }

    public function publishActivity($user, $song)
    {
        $this->_recommenderBuilderRepository->publishActivity($user, $song);
    }
}