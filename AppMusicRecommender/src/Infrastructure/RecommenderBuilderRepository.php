<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 2/12/15
 * Time: 18:21
 */

namespace Infrastructure;

use AppBundle\Entity\Activity;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\EntityManager;

class RecommenderBuilderRepository
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

    public function publishActivity($user, $song)
    {
        try {
            $act = new Activity($user, $song->getNameSong(), $song->getNameArtist(), $song->getTrack()->getNameAlbum(), $song->getNameGenere());
            $this->doctrine->persist($act);
            $this->doctrine->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}