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

class AboutController extends Controller {

    /**
     * @Route("/about");
     */
    public function aboutAction() {
         $html = $this->container->get('templating')->render('gallery/about.html.twig');
            return new Response($html);
    }

}
