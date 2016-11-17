<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function authAction()
    {
        return $this->render(
            'UserBundle:User:login.html.twig'
        );
    }
    public function signAction()
    {
    	var_dump($_POST[0]); die;
    	if(isset($_POST) && isset($_POST['form_password'])){
    		$repository = $this
			  ->getDoctrine()
			  ->getManager()
			  ->getRepository('BlogBundle:User')
			;
			var_dump($_POST); die;
			$user = $repository->findBy(
			  array('username' => $_POST['form_username'], 'password' => $_POST['form_password']) // Critere                              // Offset
			);
    	}
        return $this->render(
            'UserBundle:User:login.html.twig'
        );
    
}
    public function ragistrationAction()
    {
        return $this->render(
            'UserBundle:User:login.html.twig'
        );
    }
}    