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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExhibitionController extends Controller {

    /**
     * @Route("/exhibition");
     */
    public function exhibitionAction() {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT e from AppBundle:Exhibitions e');
        $exhibitions = $query->getResult();

        $html = $this->container->get('templating')->render('gallery/exhibition.html.twig', array('exhibitionsList' => $exhibitions));
        return new Response($html);
    }

    /**
     * @Route("/exhibitionajax");
     */
    public function exhibitionajaxAction(Request $request) {

        //if ($request->isXMLHttpRequest()) {
        
       
            //$id = $request->request->get('id');
            $id=$_POST['id'];
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT e from AppBundle:Exhibitions e where e.id=' . $id);
            $exhibition = $query->getResult();
            
            //echo("<script>console.log('PHP: ".$exhibition[0]->getDescription()."');</script>");
            
            $response = json_encode(array('message' => $exhibition[0]->getDescription()));

            //return new JsonResponse(array('message' => 'hello'));
              
              return new Response($response, 
                                    Response::HTTP_OK, 
                                    array('Content-Type' => 'application/json')); 
            
            /*
            $response = new Response(json_encode(array('name' => 'hello')));
            $response->headers->set('Content-Type', 'application/json'); */

            //return $response;
            
            
            // return Response(\json_encode(array("message" => "hello")));
             
            //}
    }

}
