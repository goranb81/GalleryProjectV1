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

class AdminController extends Controller {

    /**
     * @Route("/admin");
     */
    public function adminAction() {
       
            //$html = $this->container->get('templating')->render('gallery/base_gallery.html.twig');
            //return new Response('<html><body>Admin page!</body></html>');
        return $this->render('gallery/admin/admin.html.twig');  
    }

}

