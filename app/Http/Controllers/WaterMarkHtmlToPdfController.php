<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;
use Ajaxray\PHPWatermark\Watermark;

use Dompdf\Dompdf;
// Reference the Options namespace
use Dompdf\Options;



class WaterMarkPdfController extends Controller
{
    public function __construct()
    {

    }

    public function addPdfWatermark()
    {
        /*
        // Initiate with source image or pdf AOILTD-Guarantors_Form
        $watermark = new Watermark(public_path('imageMain.jpg'));

        // Customize some options (See list of supported options below)
        $watermark->setFontSize(30)
                    ->setRotate(30)
                    ->setOpacity(.5);

        // Watermark with Text
        $watermark->withText('shopstore4me.com', public_path('imageMain2.jpg'));

        // Watermark with Image
        $watermark->withImage(public_path('nicn-logo.png'), public_path('imageMain1.jpg'));

        */



        // Set options to enable embedded PHP
        $options = new Options();
        $options->set('isPhpEnabled', 'true');

        // Instantiate dompdf class
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml('<h1>Welcome to CodexWorld.com</h1>');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Instantiate canvas instance
        $canvas = $dompdf->getCanvas();

        // Get height and width of page
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Specify watermark image
        $imageURL = public_path('nicn-logo.png');
        $imgWidth = 200;
        $imgHeight = 200;

        // Set image opacity
        $canvas->set_opacity(.5);

        // Specify horizontal and vertical position
        $x = (($w-$imgWidth)/2);
        $y = (($h-$imgHeight)/2);

        // Add an image to the pdf
        $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight);

        // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream('document.pdf', array("Attachment" => 0));


        //return 'Successfully Generated';

    }


}
