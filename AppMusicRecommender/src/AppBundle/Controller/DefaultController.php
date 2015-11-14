<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Library\ApiRadio;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $rdio = new Rdio("xqw3ftmgbnbr5bciccwwjrdzvi", "qgHQ87hhDlCbxYK0uBogVA");
        // work out our current URL.
        $protocol = 'http';
        if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
            $protocol .= 's';
            $protocol_port = $_SERVER['SERVER_PORT'];
        } else {
            $protocol_port = 80;
        }
        $host = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'];
        $request = $_SERVER['PHP_SELF'];
        $query = substr($_SERVER['argv'][0], strpos($_SERVER['argv'][0], ';') + 1);
        $BASEURL = $protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request;
        $op = $_GET["op"];

        if($op == "login") {
            $callback_url = $BASEURL . '?op=login-callback';
            $auth_url = $rdio->begin_authentication($callback_url);
            header("Location: ".$auth_url);
        } else if($op == "login-callback") {
            $rdio->complete_authentication($_GET["oauth_verifier"]);
            header("Location: ".$BASEURL);
        } else if($op == "logout") {
            $rdio->logOut();
            header("Location: ".$BASEURL);
        } else {
            if ($rdio->loggedIn()) {
                $person = $rdio->currentUser()->result;

                // make the API call
                $results = $rdio->search(
                    array(
                        "query" => $person->firstName,
                        "types" => "Track",
                        "never_or" => "true"))->result->results;
                }
            }

        var_dump($results);
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
