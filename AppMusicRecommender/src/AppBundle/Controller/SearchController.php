<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Echonest\Facade\Echonest;
use Echonest\Facade\EchonestSongs;

/**
 * @Route("/listOfSongs")
 */
class SearchController extends Controller
{
    /**
     * @Route("/Search", name="listOfSongs")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/Search/{value}", name="listOfSongsWithValue")
     * @Method({"GET"})
     */
    public function showAction($value)
    {
        $echonest = Echonest::init('MDORNCSRVVWZJVJFN');
        $songs = new EchonestSongs($echonest);
        $listSongs = $songs->searchSongs($value)->get();


        return $this->render('search/index.html.twig',
            array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                'form_value'=>$listSongs,

                )
        );
    }
}
