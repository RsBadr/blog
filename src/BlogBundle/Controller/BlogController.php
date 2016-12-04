<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BlogBundle\Entity\Comment;
use BlogBundle\Entity\User;
use BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction($cpt = 0)
    {
        $cpt++;
    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('BlogBundle:Post')
		;
    $offset = $cpt*10-10;
		$listPosts = $repository->findBy(
		  array(), // Critere
		  array('published' => 'desc'),        // Tri
		  10,                              // Limite
		  $offset                               // Offset
		);
        $user = $this->getUser();
        $qb = $repository->createQueryBuilder('post');
        $count = $qb->select('COUNT(post)')->getQuery()->getSingleScalarResult();
        return $this->render(
        	'BlogBundle:Blog:index.html.twig',
        	array(
                'listPosts' => $listPosts,
                'nbrPostTotal' => $count,
                'cpt' => $cpt,
                'user' => $user,

                )
        	);
    }

     public function getPostAction($id,Request $request)
    {
    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('BlogBundle:Post')
  		;
      $user = $this->getUser();
      $post = $repository->find($id);
      $comment = new Comment();
      $form = $this->createForm(CommentType::class, $comment);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $comment->setAuthor($this->getUser());
        $comment->setPostCommented($post);
        $em->persist($comment);
        $em->flush($comment);
      }
      return $this->render(
      	'BlogBundle:Blog:post.html.twig',
        array('post'  => $post, 'user' => $user, 'form' => $form->createView())
          );
      }


public function searchAction()
{
  if (isset($_POST["search"]) && isset($_POST["typesearch"])) {
    if($_POST["typesearch"] == "Articles"){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('BlogBundle:Post')
      ;
      $results = $repository->findAll();
      $searchResult = array();
      foreach ($results as $result) {
        if (strpos($result->getTitle(), $_POST["search"]) !== false OR strpos($result->getContent(), $_POST["search"]) !== false) {
            array_push($searchResult, $result);
        }
      }
    }else {
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('BlogBundle:User')
      ;
      $result = $repository->findOneBy(
        array('statut' => 1, 'username' => $_POST["search"]) // Critere
      );
      $searchResult=$result->getPosts();
    }

   $user = $this->getUser();
   return $this->render(
     'BlogBundle:Blog:resultSearch.html.twig',
     array('results'  => $searchResult, 'user' => $user, 'search' => $_POST["search"], 'typesearch'=> $_POST["typesearch"])
       );
     }
     else {
       $user = $this->getUser();
       return $this->render(
         'BlogBundle:Blog:resultSearch.html.twig',
         array( 'user' => $user, 'error' => "Recherche non conforme")
           );
         }
     }

    public function contactAction()
    {
      if(isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["content"]) && isset($_POST["email"])){
        $message = \Swift_Message::newInstance()
            ->setFrom('herress.badr@gmail.com')
            ->setTo($_POST["email"])
            ->setBody($_POST["content"])
        ;
        $this->get('mailer')->send($message);
        return new Response("success");
      }else{
        return $this->render(
          'BlogBundle:Blog:contact.html.twig',
          array( 'success' => 1)
        );
      }

    }

}
