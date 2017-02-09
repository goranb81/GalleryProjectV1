<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use AppBundle\Entity\Exhibitions;
use DateTime;
use Doctrine\Query\Doctrine_Query;

class EditExhibitionsController extends Controller {

    /**
     * @Route("admin/editexhibitions", name="editexhibitions")
     */
    public function editexhibitionsAction(Request $request) {
        return $this->render('gallery/admin/edit_exhibitions.html.twig');
    }

    /**
     * @Route("admin/editexhibitions/addremoveexhibitions", name="addremoveexhibitions")
     */
    public function addremoveexhibitionsAction() {

        //check if submit new-exhibition button
        //$submitNewExhibition = isset(\filter_input(\INPUT_POST, 'new-exhibition'));
        $resultMessage = 'Poruka o akciji unesi novu izlozbu';
        $submitNewExhibition = isset($_POST['new-exhibition']);
        if ($submitNewExhibition) {
            $resultMessage = $this->newExhibitionPressed($resultMessage);
        }

        //check if submitt del-exhibition button
        $submitDeleteExhibition = isset($_POST['del-exhibition']);
        if ($submitDeleteExhibition) {
            $resultMessage = $this->delExhibitionPressed($resultMessage);
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('Select e from AppBundle:Exhibitions e');
        $exhibitions = $query->getResult();
        return $this->render('gallery/admin/edit_exhibitions_add_remove_exhibition.html.twig', array('exhibitionsList' => $exhibitions, 'resultMessage' => $resultMessage));
    }
    
    /**
     * @Route("admin/editexhibitions/addremoveexhibitionimages", name="addremoveexhibitionimages")
     */
    public function addremoveexhibitionimagesAction() {

       $em = $this->getDoctrine()->getManager();
       $query = $em->createQuery('SELECT e from AppBundle:Exhibitions e');
       $exhibitions = $query->getResult();
       
       $html = $this->container->get('templating')->render('gallery/admin/edit_exhibitions_add_remove_images.html.twig', array('exhibitionsList'=>$exhibitions));
       return new Response($html);
    }
    
    // remove all files and subdir in directory. Finally remove that directory
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
    
    // when new-exhibition button pressed
    function newExhibitionPressed() {
        $exhibition = new Exhibitions();
        //$date = \filter_input(\INPUT_POST, 'exh_date');
        //$date = strt$_POST['exh_date'];
        //$date = \date("Y-m-d H:i:s", \strtotime($_POST['exh_date']));
        $date = new DateTime(\date("Y-m-d H:i:s", \strtotime($_POST['exh_date'])));
        $exhibition->setDatetime1($date);
        //$name = \filter_input(\INPUT_POST, 'fname');
        $name = $_POST['fname'];
        $exhibition->setName($name);
        //$description = \filter_input(\INPUT_POST, 'description');
        $description = $_POST['description'];
        $exhibition->setDescription($description);

        //create exhibition directory in web/exhibitions
        try {
            $path = $this->get('kernel')->getRootDir() . '/../web/exhibitions';
            mkdir($path . '/' . $name);

            // persists exhibitions informations in DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($exhibition);
            $em->flush();
            return $resultMessage = 'Izlozba je uneta!';
        } catch (Exception $exception) {
            return $resultMessage = $exception->getMessage();
        }
    }
    
    // when del-exhibition button pressed
    function delExhibitionPressed() {
        //check if submitt del-exhibition button
        $exhibitionID = $_POST['id'];

        //select from DB array of entity objects which satisfy where condition (find exhibition by ID)
        try {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('Select e from AppBundle:Exhibitions e where e.id=' . $exhibitionID);
            //$exhibition1 is array. We must have an object Exhibition
            $exhibition1 = $query->getResult();
            if (!$exhibition1) {
                return $resultMessage = $this->createNotFoundException('Izlozba nije nadjena u bazi')->getMessage();
            }

            //create exhibition object
            $exhibition = new Exhibitions();
            $exhibition = $exhibition1[0];

            //delete entity object from DB
            $em = $this->getDoctrine()->getManager();
            $em->remove($exhibition);
            $em->flush();

            //remove exhibition directory
            try {
                $path = $this->get('kernel')->getRootDir() . '/../web/exhibitions/' . $exhibition->getName();
                $this->rrmdir($path);
            } catch (Exception $exception) {
                return $resultMessage = $exception->getMessage();
            }

            return $resultMessage = "Obrisana je galerija!";
        } catch (Exception $exception) {
            return $resultMessage = $exception->getMessage();
        }
       
    }

}
