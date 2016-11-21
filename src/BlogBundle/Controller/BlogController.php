<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
		$listPosts = $repository->findBy(
		  array(), // Critere
		  array('published' => 'desc'),        // Tri
		  10,                              // Limite
		  0                               // Offset
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
                'user' => $user
                )
        	);
    }

     public function getPostAction($id)
    {
    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('BlogBundle:Post')
		;
    $user = $this->getUser();
		$post = $repository->find($id);
        return $this->render(
        	'BlogBundle:Blog:post.html.twig',
        	array('post'  => $post, 'user' => $user)

        );
    }
}
