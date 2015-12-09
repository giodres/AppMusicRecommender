<?php

namespace AppBundle\Controller;

use Library\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

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
        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $songTrack = $this->_musicServiceLibrary->getSongsByArtist($value);
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                "result" => $songTrack
            )
        );
    }

    /**
     * @Route("/SongStyle", name="SongStyle")
     * @Method({"POST"})
     */
    public function SongStyleAction(Request $request)
    {
        $style = $request->request->get('style');
        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $songTrack = $this->_musicServiceLibrary->getSongsByNameStyle($style);
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                "result" => $songTrack
            )
        );
    }

}
