<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Form\PostType;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     */
    public function indexAction($username, $cpt = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $cpt++;
        $postRepository = $em->getRepository('BlogBundle:Post');
        $offset = ($cpt*10)-10;
        $posts = $postRepository->findBy(
        		  array('author' => $this->getUser()), // Critere
        		  array('published' => 'desc'),        // Tri
        		  10,                              // Limite
        		  $offset                              // Offset
        		);
        $user = $this->getUser();
        $qb = $postRepository->createQueryBuilder('post');
        $count = $qb->select('COUNT(post)')->getQuery()->getSingleScalarResult();
        return $this->render(
        'BlogBundle:Post:index.html.twig',
        array(
                'listPosts' => $posts,
                'nbrPostTotal' => $count,
                'cpt' => $cpt,
                'user' => $user
                )
          );
    }

    /**
     * Creates a new post entity.
     *
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setAuthor($this->getUser());
            # to keep letters & numbers
            $s = $post->getTitle();
            $s = preg_replace('/[^a-z0-9]+/i', '_', $s); # or...
            $s = preg_replace('/[^a-z\d]+/i', '_', $s);

            # to keep letters only
            $s = preg_replace('/[^a-z]+/i', '_', $s);

            # to keep letters, numbers & underscore
            $s = preg_replace('/[^\w]+/', '_', $s);

            # same as third example; suggested by @tchrist; ^\w = \W
            $s = preg_replace('/\W+/', '_', $s);
            $post->setUrlAlias($s);
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        return $this->render('BlogBundle:Post:new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('post/show.html.twig', array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
        }

        return $this->render('post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush($post);
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
