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
use AppExternalClass\HandleImages;
use AppExternalClass\PictureInfo;

class GalleryController extends Controller {

    /**
     * @Route("/gallery/{gallery}");
     */
    public function galleryAction($gallery) {
        $hI = new HandleImages();
        
        $dir = '';
        $dirName = '';
        if($gallery == 'gallery'){
            $dir = $this->get('kernel')->getRootDir() . '/../web' . '/img';
            $dirName = 'img/';
        }else{
            $dir = $this->get('kernel')->getRootDir() . '/../web' . '/exhibitions/' . $gallery;
            $dirName = 'exhibitions/' . $gallery .'/';
        }
        
        $filesInFolder = new \DirectoryIterator($dir);

        /* OLD CODE
         * 
          $htmlContent = "<div id='links'>";
          while ($filesInFolder->valid()) {
          $file = $filesInFolder->current();
          $filename = $file->getFilename();

          //check if file ends with 'thumb'. If ends then skip that file
          $bool = $hI->isThubmle($filename);
          if ($filename <> '.' and $filename <> '..' and $filename <> 'thumbnails' and $bool) {
          $file = "$filename";

          $htmlContent .= "<a href='/img/" . $file . "'" . "title='" . $hI->createTitleSource($filename) . "'" . "data-dialog>";
          $htmlContent .= "<img src='" . $hI->createThumbImageSource($filename) . "' alt='" . $hI->createTitleSource($filename) . "'>";
          $htmlContent .= "</a>";
          }

          $filesInFolder->next();
          }
          $htmlContent .= "</div>";

         * END OLD CODE
         */

        /* OLD CODE 1
          $htmlContent = "<div id='links'>";
          while ($filesInFolder->valid()) {
          $file = $filesInFolder->current();
          $filename = $file->getFilename();

          //check if file ends with 'thumb'. If ends then skip that file
          $bool = $hI->isThubmle($filename);
          if ($filename <> '.' and $filename <> '..' and $filename <> 'thumbnails' and $bool) {
          $file = "$filename";

          $htmlContent .= "<a href='/img/" . $file . "'" . "title='" . $hI->createTitleSource($filename) . "'" . "data-dialog>";
          $htmlContent .= "<img src='" . $hI->createThumbImageSource($filename) . "' alt='" . $hI->createTitleSource($filename) . "'>";
          $htmlContent .= "</a>";
          }

          $filesInFolder->next();
          }
          $htmlContent .= "</div>";

          $htmlArray = array();
          $htmlArray[0] = $htmlContent;
         * 
         * END OLD CODE 1
         */
        
         /* OLD CODE 2
        $htmlContent = "<div id='links'>";
        while ($filesInFolder->valid()) {
            $file = $filesInFolder->current();
            $filename = $file->getFilename();

            //check if file ends with 'thumb'. If ends then skip that file
            $bool = $hI->isThubmle($filename);
            if ($filename <> '.' and $filename <> '..' and $filename <> 'thumbnails' and $bool) {

                //<img src= "{{ asset('img/druga_slika.jpg') }}" />
                $htmlContent .= '<a href="' . $hI->createImageSource($filename) . '" ' . " title='" . $hI->createTitleSource($filename) . "'" . " data-dialog>";
                $htmlContent .= '<img src="' . $hI->createThumbImageSource($filename) . '" alt="' . $hI->createTitleSource($filename) . ' ">';
                $htmlContent .= "</a>";
            }

            $filesInFolder->next();
        }
        $htmlContent .= "</div>";
        * END OLD CODE 2
        */

        /* HTML content which send to template
        $htmlArray = array();
        $htmlArray[0] = $htmlContent;
        * 
        */
        
       $i = 0;
       $pictures = array();
        while ($filesInFolder->valid()) {
            $file = $filesInFolder->current();
            $filename = $file->getFilename();

            //check if file ends with 'thumb'. If ends then skip that file
            $bool = $hI->isThubmle($filename);
            if ($filename <> '.' and $filename <> '..' and $bool) {
                $pi = new PictureInfo();
                $pi->name = $dirName . $hI->createImageSource($filename);
                $pi->thumbleName = $dirName . $hI->createThumbImageSource($filename);
                $pi->title = $hI->createTitleSource($filename);
                $pictures[$i] = $pi;
            }

            $filesInFolder->next();
            $i = $i+1;
        }
         
        $html = $this->container->get('templating')->render('gallery/gallery.html.twig', array('pictures' => $pictures, 'dirName'=>$dirName));
        return new Response($html);
        
        //'names' => $names, 'thumbNames' => $thumbNames, 'titleNames' => $titleNames
    }

}
