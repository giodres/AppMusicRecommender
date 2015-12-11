<?php

namespace AppBundle\Controller;

use Library\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $genres = $this->_musicServiceLibrary->getAllGenres();
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                "result" => null,
                "genres" => $genres
            )
        );
    }

    /**
     * @Route("/Artist/", name="getListBySinger")
     * @Method({"GET"})
     */
    public function showAction(Request $request)
    {
        $value = $request->query->get('title');
        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $songTrack = $this->_musicServiceLibrary->getSongsByArtist($value);
        $genres = $this->_musicServiceLibrary->getAllGenres();
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                "result" => $songTrack,
                "genres" => $genres
            )
        );
    }

    /**
     * @Route("/Song/", name="getListBySong")
     * @Method({"GET"})
     */
    public function getListBySongAction(Request $request)
    {
        $value = $request->query->get('title');
        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $songTrack = $this->_musicServiceLibrary->getSongsByTitle($value);
        $genres = $this->_musicServiceLibrary->getAllGenres();
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                "result" => $songTrack,
                "genres" => $genres
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
        $genres = $this->_musicServiceLibrary->getAllGenres();
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                "result" => $songTrack,
                "genres" => $genres
            )
        );
    }

}
