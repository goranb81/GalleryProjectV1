<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// src/AppBundle/Controller/LuckyController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use AppExternalClass\HandleImages;



class LuckyController extends Controller{

/**
 * @Route("/lucky/number")
 */
public function numberAction() {
$number = rand(0, 100);
return new Response(
'<html><body>Lucky number: ' . $number . '</body></html>'
);
}

/**
 * @Route("/api/lucky/number")
 */
public function apiNumberAction()
{
$data = array(
'lucky_number' => rand(0, 100),
);
return new Response(
json_encode($data),
 200,
 array('Content-Type' => 'application/json')
);
}

/**
* @Route("/lucky/number/{count}")
*/
public function numberAction1($count)
{
    
    /*
    $numbers = array();
for ($i = 0; $i < $count; $i++) {
$numbers[] = rand(0, 100);
}
$numbersList = implode(', ', $numbers); */
        
        //$path =  $this->get('kernel')->getRootDir() . '/../lib';
    
    
        
    
        //$loader = new UniversalClassLoader();
        //$loader->register();
        //$loader->registerNamespace('Handle', $this->get('kernel')->getRootDir() . '/../lib');
        
        
        $hI = new HandleImages();
        $dir = $this->get('kernel')->getRootDir() . '/../web' . '/img';
        $filesInFolder = new \DirectoryIterator($dir);
        
        $htmlContent = "<div id='links'>";
        while ($filesInFolder->valid()) {
            $file = $filesInFolder->current();
            $filename = $file->getFilename();
            
            //check if file ends with 'thumb'. If ends then skip that file
            $bool = $hI->isThubmle($filename);
            if($filename <> '.' and $filename <> '..' and $filename <> 'thumbnails' and $bool){
                
                //<img src= "{{ asset('img/druga_slika.jpg') }}" />
                $htmlContent .= '<a href="' . $hI->createImageSource($filename) . '" ' . "title='" . $hI->createTitleSource($filename) . "'" . "data-dialog>";
                $htmlContent .= '<img src="' . $hI->createThumbImageSource($filename) . '" alt="' . $hI->createTitleSource($filename) . "'>";
                $htmlContent .= "</a>";
                
            }
            
            $filesInFolder->next();
        }
        $htmlContent .= "</div>";
        
        $htmlArray = array();
        $htmlArray[0] = $htmlContent;
        //$array[] = $htmlContent;
        

//$html = $this->container->get('templating')->render('lucky/number.html.twig', array('luckyNumberList'=>$files));
        
    
         /*   
         $pom = $this->get('kernel');
         $loader = new UniversalClassLoader();
         $loader->registerNamespace('Handle\HandleImage', $pom->getRootDir() . '/../src/AppExternalClass');
         $loader->useIncludePath(true);
         $loader->register();
          */
         
         //$handleImage = new HandleImage();
         //$htmlContent = array();
         //$htmlContent[0] = $handleImage->handle();
        $html = $this->container->get('templating')->render('lucky/number.html.twig', array('luckyNumberList'=>$htmlArray));        
        return new Response($html);
          
         
}

/*
public function createTitleSource($filename){
    $splitArray = \explode('.', $filename);
    $string = $splitArray[0];
    
    $splitArray1 = explode('_', $string);
	
    $title = '';
    foreach($splitArray1 as $namePart){
	$title .= $namePart . ' ';
    }
    
    return $title;
}

public function createThumbImageSource($filename, $dir){
    $splitArray = \explode('.', $filename);
    $name = $splitArray[0];
    
    $imageSource = "$dir/$name"."_thumb.jpg";
    return $imageSource;
}
 
 */



/**
 * @Route("/lucky/createTable")
 */
public function createTableAction() {
    $entityManager = $this->getDoctrine()->getManager();
    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
    $classes = $entityManager->getMetadataFactory()->getAllMetadata();
    $schemaTool->createSchema($classes);

}
}

