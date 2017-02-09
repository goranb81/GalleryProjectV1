<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppExternalClass;

use Exception;

class Uploader {

    private $filename;
    private $destination;
    private $fileData;
    private $errorMessage;
    private $errorCode;

    public function __construct($key) {
        $this->filename = $_FILES[$key]['name'];
        $this->fileData = $_FILES[$key]['tmp_name'];

        $this->errorCode = ($_FILES[$key]['error']);
    }

    public function saveIn($folder) {
        $this->destination = $folder;
    }

    public function save() {
        //call the new method to look for upload errors
        //if it returns TRUE, save the uploaded file
        if ($this->readyToUpload()) {
            move_uploaded_file(
                    $this->fileData, "$this->destination/$this->filename");
        } else {
            //if not create an exception - pass error message as argument
            $exc = new Exception($this->errorMessage);
            //throw the exception
            throw $exc;
        }
    }

    public function getFilename() {
        return $this->filename;
    }

    private function readyToUpload() {
        $folderIsWriteAble = is_writable($this->destination);
        if ($folderIsWriteAble === false) {
            //provide a meaningful error message
            $this->errorMessage = "Error: destination folder is ";
            $this->errorMessage .= "not writable, change permissions";
            //indicate that code is NOT ready to upload file
            $canUpload = false;
        } else if ($this->errorCode === 1) {
            $maxSize = ini_get('upload_max_filesize');
            $this->errorMessage = "Error: File is too big. ";
            $this->errorMessage .= "Max file size is $maxSize";
            $canUpload = false;
            //end of new code
        }  //the error codes have values 1 to 8
        //we already check for code 1
        //if error code is greater than one, some other error occurred
        else if ($this->errorCode > 1) {
            $this->errorMessage = "Something went wrong! ";
            $this->errorMessage .= "Error code: $this->errorCode";
            $canUpload = false;
            //end of new code
            //if error code is none of the above
            //we can safely assume no error occurred	
        } else {
            //assume no other errors - indicate we're ready to upload
            $canUpload = true;
        }
        return $canUpload;
    }

    private function imagesPaths() {
        $imagePaths = array();
        $filesInFolder = new DirectoryIterator($this->destination);
        //loop through all files in img folder
        $i=0;
        while ($filesInFolder->valid()) {
            $file = $filesInFolder->current();
            $filename = $file->getFilename();
            $src = "$this->destination/$filename";
            $fileInfo = new Finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fileInfo->file($src);
            //if file is a jpg...
            if ($mimeType === 'image/jpeg') {
                $imagePaths[$i] = $src;
                $i = $i+1;
            }
            $filesInFolder->next();
        }
        
        return $imagePaths;
    }

}
