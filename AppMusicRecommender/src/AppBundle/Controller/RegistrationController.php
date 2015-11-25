<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 22/11/15
 * Time: 18:34
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
Use AppBundle\Form\UserType;


class RegistrationController extends Controller
{


    /**
     * @InjectParams({
     *    "_userServiceLibrary" = @Inject("imp.service.registration")
     * })
     */
    protected $_userServiceLibrary;


    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        $this->_userServiceLibrary = $this->container->get("imp.service.library");
        //$this->_userServiceLibrary = new UserServiceLibrary();
        try {
            $user = $this->_userServiceLibrary->getInstanceUser();
            $form = $this->generateForm($request,$user);
            $isCreate = $this->createNewUser($form,$user);
            if($isCreate) return $this->redirectToRoute('login_route');
            return $this->render(
                'security/register.html.twig',
                array('form' => $form->createView())
            );
        } catch(Exception $e) {
        }
    }


    private function generateForm($request,$user) {
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        return $form;
    }

    private function createNewUser($form, $user) {
        if ($form->isValid() && $form->isSubmitted())  return $this->_userServiceLibrary->createNewUser($user);
    }


}