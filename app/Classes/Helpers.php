<?php

namespace Classes;
use Illuminate\Http\Request;

class Helpers
{
    /*
     * Variavel para determinar qual pasta será salvo as imagens
     * Além de determinar a pasta para o método move do Symphone
     * também serve para determinar o drive de armazenamento do
     * Storage do Laravel, configurado em "config->filesystems.php"
     */
    private $diretorioDrive = '';
    private $loadImg = [];

    public function __construct($diretorioDrive = 'images')
    {
        $this->diretorioDrive = $diretorioDrive;
    }

    public function loadImg($imgRequest)
    {
        $file = $imgRequest;
        $this->loadImg['File'] = $file;
        $this->loadImg['MimeType'] = $file->getMimeType();
        $this->loadImg['OriginalName'] = $file->getClientOriginalName();
        $this->loadImg['OriginalExtension'] = $file->getClientOriginalExtension();
        $this->loadImg['RealPath'] = $file->getRealPath();
        $this->loadImg['Size'] = $file->getSize();
        //$file->move($caminhoSistema, $img->nomearquivo_img);

        return $this->loadImg;
    }

    public function hex2rgb($hex)
    {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
       // How to use
       // $rgb = hex2rgb("#cc0");
    }

    public function rgb2hex($rgb) // $rgb = array de 3 posições. Ex: [255,255,255]
    {
       $hex = "#";
       $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

       return $hex; // returns the hex value including the number sign (#)
       // How to use
       // $rgb = array( 255, 255, 255 );
       // $hex = rgb2hex($rgb);
    }
}