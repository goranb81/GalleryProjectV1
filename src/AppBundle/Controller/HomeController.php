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

class HomeController extends Controller {

    /**
     * @Route("/home");
     */
    public function homeAction() {
        $html = $this->container->get('templating')->render('gallery/home.html.twig');
        return new Response($html);
       
    }
    /*
     " <!DOCTYPE html>
            <html>
                <head>
                    <title>Home page</title>
                </head>
                <body>
                    <nav id='admin-navigation'>
                         <a href='http://localhost/Symphony2Test/symfony-standard-master/web/app_dev.php/about'>O MENI</a>
                        <a href='http://localhost/Symphony2Test/symfony-standard-master/web/app_dev.php/gallery'>GALERIJA</a>
                        <a href='http://localhost/Symphony2Test/symfony-standard-master/web/app_dev.php/exhibition'>IZLOZBE</a>
                        <a href='http://localhost/Symphony2Test/symfony-standard-master/web/app_dev.php/portrait'>POTRET SA IVANOM</a>
                        <a href='http://localhost/Symphony2Test/symfony-standard-master/web/app_dev.php/contact'>KONTAKT</a>
                    </nav>
                </body>  
            </html>"
     * */
     

}
