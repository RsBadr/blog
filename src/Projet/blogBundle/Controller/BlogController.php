<?php

namespace Projet\blogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction($cpt = 0)
    {
        $cpt++;
    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('ProjetblogBundle:Post')
		;
		$listPosts = $repository->findBy(
		  array(), // Critere
		  array('published' => 'desc'),        // Tri
		  10,                              // Limite
		  0                               // Offset
		);

        $qb = $repository->createQueryBuilder('post');
        $count = $qb->select('COUNT(post)')->getQuery()->getSingleScalarResult();
        return $this->render(
        	'ProjetblogBundle:Blog:index.html.twig',
        	array(
                'listPosts' => $listPosts,
                'nbrPostTotal' => $count,
                'cpt' => $cpt
                )
        	);
    }

     public function getPostAction($id)
    {
    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('ProjetblogBundle:Post')
		;
		$post = $repository->find($id);
        return $this->render(
        	'ProjetblogBundle:Blog:post.html.twig', 
        	array('post'  => $post)
        );
    }
}