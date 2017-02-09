<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppExternalClass\Uploader;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use DirectoryIterator;
use Finfo;

class EditgalleryController extends Controller {

    /**
     * @Route("admin/editgallery/{gallery}", name="editgallery")
     */
    public function editgalleryAction($gallery) {
        
        // Path to folder web for example on lovalhost is C:\xampp\htdocs\GalleryProjectV1\web
        $pathToFolderWeb = realpath('../web');
        
        $galleryName = '';
        if($gallery == 'gallery'){
            $galleryName = 'img';
        }else{
            $galleryName = 'exhibitions\\' . $gallery;
        }
        
        //check if submit button press.
        $imageSubmitted = isset($_POST['new-image']);
	$uploadMessage = "Upload a file.";
	if($imageSubmitted){
                $uploader = new Uploader('image-data');
		$uploader->saveIn($pathToFolderWeb . '\\' . $galleryName);
		//try to save the upload file
		try {
			$uploader->save();
			//create an upload message that confirms succesful upload
			$uploadMessage = "file uploaded!";
                        
                        //return $this->redirectToRoute('http://localhost/GalleryProjectV1/web/app_dev.php/admin/editgallery');
			//catch any exception thrown
		} catch ( Exception $exception ) {
			//use the exception to create an upload message
			$uploadMessage = $exception->getMessage();
		}
	}
	
        
        // check if link delete press
        
	$deleteImage = isset( $_POST['delete_image'] );
	if ( $deleteImage ) {
		//grab the src of the image to delete
		$whichImage = $_POST['delete_file'];
                if (file_exists($whichImage)) {
                    unlink($whichImage);
                    $uploadMessage = 'File deleted!';
                }
		
	}
        
        
        
        //create array of image destination from particularly folder
        $imagePaths = array();
        if($gallery == 'gallery'){
            $folder = '/img';
            $folder1 = $pathToFolderWeb . '\img';
        }else{
            $folder = '/exhibitions/' . $gallery;
            $folder1 = $pathToFolderWeb . '\exhibitions\\' . $gallery;
        }
        
        $path = $this->get('kernel')->getRootDir() . '/../web' . $folder;
        
        $filesInFolder = new DirectoryIterator($path);
        //loop through all files in img folder
        $i=0;
        while ($filesInFolder->valid()) {
            $file = $filesInFolder->current();
            $filename = $file->getFilename();
            $src = "$path/$filename";
            $fileInfo = new Finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fileInfo->file($src);
            //if file is a jpg...
            if ($mimeType === 'image/jpeg') {
                // use src1 to provide /img/filename 
                // otherwice we provide C:\xampp\htdocs\GalleryProjectV1\app/../web/img/deveta_slika.jpg
                // and then image doesn't render on webpage
                $pathClass = new \stdClass();
                
                $src1 = "$folder/$filename";
                $src2 = "$folder1\\$filename"; 
                
                // image path for display images
                $pathClass -> imagePath1 = $src1;
                // image path for delete images
                $pathClass -> imagePath2 = $src2;
                
                $imagePaths[$i] = $pathClass;
                $i = $i+1;
            }
            $filesInFolder->next();
        }
        
        
        
     
           return $this->render('gallery/admin/edit_gallery.html.twig', array('uploadMessage' => $uploadMessage, 'imagesPaths' => $imagePaths));  
    }

}

