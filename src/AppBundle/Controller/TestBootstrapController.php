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

class TestBootstrapController extends Controller{
    
    /**
     * @Route("/testbootstrap");
     */
    public function testBootstrapAction() {     
        $html = $this->container->get('templating')->render('/testBootstrap/testBootstrap.html.twig');
        return new Response($html);
    }
    
    /**
     * @Route("/bootstrapoffset");
     */
    public function offsetBootstrapAction() {     
        $html = $this->container->get('templating')->render('/testBootstrap/testBootstrapOffset.html.twig');
        return new Response($html);
    }
    
    /**
     * @Route("/bootstrapimage");
     */
    public function imageBootstrapAction() {     
        $html = $this->container->get('templating')->render('/testBootstrap/testBootstrapImage.html.twig');
        return new Response($html);
    }
}
