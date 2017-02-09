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

class PortraitController extends Controller {

    /**
     * @Route("/portrait");
     */
    public function portraitAction() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT v FROM AppBundle:Videos v');
        $videos = $query->getResult();
        
        $html = $this->container->get('templating')->render('gallery/portrait.html.twig', array('videosList'=>$videos));
        return new Response($html);
    }

}
