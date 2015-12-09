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

    public function getActivity($user, $idSong)
    {//var_dump($user->getUser()->getId());
        $query = $this->doctrine->getRepository("AppBundle:Activity")
            ->findBy(array('idSong' => $idSong, 'user' => $user->getId()));
        if ($query != null) return $query;
        return null;
    }

    public function publishActivity($user, $song)
    {
        try {
            $act = new Activity($user, $song->getId(), $song->getIdArtist(), $song->getTrack()->getIdAlbum(), $song->getIdGenere());
            $this->doctrine->persist($act);
            $this->doctrine->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function updateActivity($user, $idActivity)
    {
        try {
            $activity = $this->doctrine->getRepository("AppBundle:Activity")
                ->findBy(array('idActivity' => $idActivity, 'user' => $user->getId()));
            $activity->summClick();
            $this->doctrine->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}