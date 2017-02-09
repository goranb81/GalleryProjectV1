<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Comments;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller {

    /**
     * @Route("/contact", name="contact") 
     */
    public function contactAction(Request $request) {
        
        $comments = new Comments();
        $comments->setName('Enter name');
        $comments->setEmail('Enter email');
        $comments->setDescription('Enter comment');
        $date = new \DateTime();
        $comments->setDatetime1($date);
        
        $form = $this->createFormBuilder($comments)
                ->add('name', TextType::class)
                ->add('email', TextType::class)
                ->add('description', TextareaType::class)
                ->add('submit', SubmitType::class, array('label' => 'SUBMIT'))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comments);
            $em->flush(); 
            return $this->redirectToRoute('contact');
        }

     
       /*
        * $html = $this->container->get('templating')->render('
        * gallery/contact.html.twig');
            return new Response($html);
        */
           return $this->render('gallery/contact.html.twig', array('form' => $form->createView()));  
    }

}

