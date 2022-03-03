<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;

class WaterMarkController extends Controller
{
    public function __construct()
    {

    }


    public function createImageWatermark()
    {
        return $this->imageWatermarkFun('main-img.jpg', 'FindMe-chat.png', 'main-img-new.jpg');

     }


     private function imageWatermarkFun($mainImageWithPath = 'main-img.jpg', $watermarkImageWithPath = 'FindMe-chat.png', $newImageNameWithPath = 'main-img-new.jpg', $bottomMargin = 10, $rightMargin = 10)
     {
        $success = 0;
        try{
            if($mainImageWithPath <> null && $watermarkImageWithPath <> null)
            {
                $img = Image::make(public_path($mainImageWithPath));
                $img->insert(public_path($watermarkImageWithPath),'bottom-right', $bottomMargin, $rightMargin);
                if($newImageNameWithPath == null)
                {
                    $img->save(); //save it in the image file
                }else{
                    $img->save(public_path($newImageNameWithPath)); //save it as a different image file
                }
                $success = 1;
            }else{
                 $success = 0;
            }

        }catch(\Throwable $e){
            $success = 0;
        }

         return $success;

     }




}
