<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\Exhibitions;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * 
     * @Route("/create", name="create")
     */
    public function createAction(){
        
        /* begin Product
        $product = new Product();
        $product->setName("Toplomer");
        $product->setPrice(10.5);
        $product->setDescription("Prakticni toplomer koji je lako prenosiv i lako primenjiv u svakoj situaciji.");
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        $productArray = array();
        $productArray[0] = $product->getId();
         * 
         * end Product
         */
        
     
            $exhibitionsArray = array();
            $em = $this->getDoctrine()->getManager();

            $exhibitions1 = new Exhibitions();
            $exhibitions1->setDatetime1(new \DateTime());
            $exhibitions1->setName("ex1");
            $exhibitions1->setDescription("Prva izlozba");
            $em->persist($exhibitions1);
            $em->flush();
            $exhibitionsArray[0] = $exhibitions1;

            $exhibitions2 = new Exhibitions();
            $exhibitions2->setDatetime1(new \DateTime());
            $exhibitions2->setName("ex2");
            $exhibitions2->setDescription("Druga izlozba");
            $em->persist($exhibitions2);
            $em->flush();
            $exhibitionsArray[1] = $exhibitions2;

            $exhibitions3 = new Exhibitions();
            $exhibitions3->setDatetime1(new \DateTime());
            $exhibitions3->setName("ex3");
            $exhibitions3->setDescription("Treca izlozba");
            $em->persist($exhibitions3);
            $em->flush();
            $exhibitionsArray[2] = $exhibitions3;
        
        
        
        /*
            $html = $this->container->get('templating')->render('lucky/number.html.twig', array('luckyNumberList'=>$exhibitionsArray));
            return Response($html);
         */
    }
    
    /**
     * 
     * @Route("/show/{id}", name="show")
     */
    public function showAction($id){
        $exhibitions = $this->getDoctrine()
                ->getRepository('AppBundle:Exhibitions')
                ->find($id);
        if(!$exhibitions){
            throw $this->createNotFoundException('No product found for id ' . $id);
        }
        
        $exhibitionsArray = array();
        $exhibitionsArray[0] = $exhibitions;
        
        $html = $this->container->get('templating')->render('lucky/number.html.twig', ['luckyNumberList'=>$exhibitionsArray]);
        return new Response($html);
    }
}
