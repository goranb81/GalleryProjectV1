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

/**
 * Description of EditCommentsController
 *
 * @author bor8246
 */
class EditCommentsController extends Controller {

    /**
     * @Route("/admin/editcomments");
     */
    public function exhibitionAction() {

        //$dateFrom1 = new DateTime(\date("Y-m-d H:i:s", \strtotime($_POST['exh_date'])));
        $submitShowComments = isset($_POST['show-comments']);

        $dateFrom = '';
        $dateTo = '';
        $timeTo = '';
        $timeFrom = '';
        if ($submitShowComments) {
            $dateFrom = $_POST['date_from'];
            $dateTo = $_POST['date_to'];
            $timeFrom = $_POST['time_from'];
            $timeTo = $_POST['time_to'];
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c from AppBundle:Comments c where (c.datetime1 >=  :date1 and c.datetime1 <= :date2)');
        $query->setParameters(array('date1' => $dateFrom . ' ' . $timeFrom, 'date2' => $dateTo . ' ' . $timeTo));
        //$query->setParameters(array('date1' => '2016-07-11 12:12:48', 'date2' => '2016-07-15 12:12:48'));

        $comments = $query->getResult();

        $html = $this->container->get('templating')->render('gallery/admin/edit_comments.html.twig', array('commentsList' => $comments, 'dateTo' => $dateTo, 'dateFrom' => $dateFrom, 'timeTo' => $timeTo, 'timeFrom' => $timeFrom));
        return new Response($html);
    }

    //'date1' => \date("Y-m-d H:i:s", \strtotime($dateFrom)), 'date2'=>\date("Y-m-d H:i:s", \strtotime($dateTo))

    /**
     * @Route("/admin/showcomment");
     */
    public function showCommentAction() {

        $id = $_POST['id'];
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c from AppBundle:Comments c where c.id=' . $id);
        $comment = $query->getResult();

        $response = json_encode(array('message' => $comment[0]->getDescription()));

        //return new JsonResponse(array('message' => 'hello'));

        return new Response($response, Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }

    //'date1' => \date("Y-m-d H:i:s", \strtotime($dateFrom)), 'date2'=>\date("Y-m-d H:i:s", \strtotime($dateTo))
}
