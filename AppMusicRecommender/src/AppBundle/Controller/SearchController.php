<?php

namespace AppBundle\Controller;

use AppBundle\Mapper\Song;
use AppBundle\Mapper\Track;
use Library\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/Search")
 */
class SearchController extends Controller
{
    /**
     * @InjectParams({
     *    "_musicServiceLibrary" = @Inject("search.controller")
     * })
     */
    protected $_musicServiceLibrary;

    /**
     * @Route("", name="listOfSongs")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/{value}", name="listOfSongsWithValue")
     * @Method({"GET"})
     */
    public function showAction($value)
    {
        $apiMusic = new MusicRepository();
        $songTrack = array();
        $songs = $apiMusic->searchSongs($value);

        foreach($songs['songs'] as $rot) {
            $rtrack = array();
            foreach($rot['tracks'] as $temp) {
                $rtrack = $temp;
                break;
            }
            if (count($rtrack) == 0) continue;
            $track = new Track($rtrack);
            $song = new Song($rot['artist_name'],$rot['title'],$track);
            if ($song->getTrack()->getPreviewUrl() == null) continue;
            $songTrack[] = $song;
        }

        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                "result" => $songTrack, 'repository' => $songs,
            )
        );
    }
}
