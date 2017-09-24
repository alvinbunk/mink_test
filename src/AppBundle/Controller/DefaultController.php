<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
    
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
    
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
	/**
	 * @Route("/insecure", name="insecure")
	 */
	public function insecureAction(Request $request)
	{
		return $this->render('security/insecure.html.twig');
	}
    
	/**
	 * @Route("/secure", name="secure")
	 */
	public function secureAction(Request $request)
	{
		return $this->render('security/secure.html.twig');
	}
    
	/**
	 * @Route("/ajax", name="ajax")
	 */
	public function ajaxAction(Request $request)
	{
		$value = "default";
		$selected = $request->query->get('item');
		
		if ($request->isXmlHttpRequest()) {
			switch($selected){
				case "Flower":
					$value = "Rose";
					break;
				case "Car":
					$value = "BMW";
					break;
				case "City":
					$value = "Taft";
					break;
				case "Country":
					$value = "USA";
					break;
			}
		}
		
		return new Response( $value );
	}
}
