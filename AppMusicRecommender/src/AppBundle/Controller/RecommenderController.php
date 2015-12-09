<?php

namespace AppBundle\Controller;

use AppBundle\Mapper\Song;
use AppBundle\Mapper\Track;
use Library\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/Recommender")
 */
class RecommenderController extends Controller
{
    protected $_musicServiceLibrary;
    protected $_recommenderServiceLibrary;

    /**
     * @Route("", name="getListRecommender")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/Singer", name="getRecomenderBySinger")
     * @Method({"GET"})
     */
    public function getRecomenderBySinger()
    {
        $this->_recommenderServiceLibrary = $this->container->get("recommender.imp.service.library");
        $this->_recommenderServiceLibrary->example();
        return $this->render('searchMain/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                "result" => null
            )
        );
    }

    /**
     * @Route("/Genere", name="getRecomenderByGenere")
     * @Method({"POST"})
     */
    public function getRecomenderByGenere($value)
    {

    }

    /**
     * @Route("/Album", name="getRecomenderByAlbum")
     * @Method({"POST"})
     */
    public function getRecomenderByAlbum($value)
    {

    }

    /**
     * @Route("/Mix", name="getRecomenderByAlbum")
     * @Method({"POST"})
     */
    public function getRecomenderMix($idSinger, $idGenere, $idAlbum)
    {

    }


    /**
     * @Route("/Activity", name="publishActivity")
     * @Method({"GET"})
     */
    public function publishActivity(Request $request)
    {

        $idSong = $request->query->get('idSong');
        $idTrack = $request->query->get('idTrack');
        $user = $this->get('security.context')->getToken()->getUser();

        $this->_musicServiceLibrary = $this->container->get("music.imp.service.library");
        $song = $this->_musicServiceLibrary->getSongsById($idSong);

        $track = Track::createTrack($idTrack);
        $track->getData();
        $song->setTrack($track);
        $song->loadData();

        $this->_recommenderServiceLibrary = $this->container->get("recommender.imp.service.library");
        $this->_recommenderServiceLibrary->publishActivity($user, $song);

        $response = new Response();
        $response->setContent(json_encode(array(
            'preview' => $track->getPreviewUrl()
        , 'image' => $track->getReleaseImage()
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
