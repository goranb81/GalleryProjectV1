<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppExternalClass;

class HandleImages {

    public function createTitleSource($filename) {
        $splitArray = \explode('.', $filename);
        $string = $splitArray[0];

        $splitArray1 = explode('_', $string);

        $title = '';
        foreach ($splitArray1 as $namePart) {
            $title .= $namePart . ' ';
        }

        return $title;
    }
    
    public function createImageSource($filename){
        //$imageSource = "'{{' asset('img/". $filename  . "') '}}'";
        //$imageSource = 'img/'. $filename;
        $imageSource = $filename;
        return $imageSource;
    }
    
    public function createThumbImageSource($filename) {
        $splitArray = \explode('.', $filename);
        $name = $splitArray[0];
        
        //{{ asset('img/druga_slika.jpg') }}
        //$imageSource = "/img/$name" . "_thumb.jpg";
        //$imageSource = "'{{' asset('img/". $name  . "_thumb.jpg') '}}'";
        //$imageSource = 'img/'. $name .'_thumb.jpg';
        $imageSource = $name .'_thumb.jpg';
        return $imageSource;
    }
    
    public function isThubmle($filename){
        $splitArray = \explode('.', $filename);
        $splitArray1 = $splitArray[0];
        $splitArray2 = \explode('_', $splitArray1);
        
        $c = \count($splitArray2);
        $lastWord = $splitArray2[$c-1];
        
        if($lastWord == 'thumb'){
            return false;
        }
            
        
        return true;
        
    }

}
