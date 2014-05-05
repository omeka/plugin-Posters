<?php

class Poster_Pdf //extends Zend_Pdf{
{
    protected $_pdf;
    protected $_template;
    protected $_font;
    protected $_pageCount = 0;
    protected $_x;
    protected $_y;



    const MARGIN_LEFT   = 13.5;
    const MARGIN_RIGHT  = 36;
    const MARGIN_TOP    = 36;
    const MARGIN_BOTTOM = 13.5;


    public function __construct()
    {
        // new pdf file will be created
        // everytime this class is called
        // this behaviour might change
       // $tmplt = dirname(__FILE__)."/PdfTemplate.pdf";
        //var_dump($tmplt);
        $this->_pdf = new Zend_Pdf();
       // if (file_exists($tmplt)){
         //   $this->_template = Zend_Pdf::load($tmplt);
        // }
        //
        //Set fonts
        $this->_font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $this->_bfont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
    
    }
    public function generate($poster)
    {

       $file = $poster->title . ".pdf";
       $run = true;
       $i = 0;
       foreach($poster->Items as $pItem){
          
          // $page = $this->_newPage($poster);

          //Only write the description if this is the first page
           if($i === 0) {
               $page = $this->_newPage($poster);
                $this->_posterDesc($poster, $page, $this->_x, $this->_y);
           }
           //Start printing the items description and images
           //foreach($poster->Items as $pItem){
           $this->_y -= 13;
               //if the title is longer than 90 characters split it into se
           foreach($this->_cleanText(metadata($pItem, array('Dublin Core', 'Title')), 90) as $t){
                    $page->setFont($this->_bfont, 12);
                    $page->drawText($t, $this->_x, $this->_y);
                    $this->_y -= 12;
           } 
               $x = $this->_x;
               // place  images in rows of 3
               
                if (metadata($pItem, 'has files')) {
                    $j = 0;
                    foreach($pItem->Files as $piFile) {
                        if($piFile->hasThumbnail()) {
                            $imgSrc = FILES_DIR . "/" . $piFile->getStoragePath();
                            //$page->drawText("$j x: $x, y: {$this->_y}", $x, $this->_y);                           
                            $image = Zend_Pdf_Image::imageWithPath($imgSrc);
                            $page->drawImage($image, $x, $this->_y - 150, $x + 150, $this->_y);
                            $x = ($j >= 2)? 50 : $x + 160;
                            $this->_y = ($j >= 2)? $this->_y - 155: $this->_y;
                            $j = $j % 2;
                         
                            $j++;                            
                        }
                    }
                }// end of image printing
               $this->_y = ($i > 0)? $this->_y - 165 : $this->_y;
              // $page->setFont($this->_font, 12);
                foreach($this->_cleanText($pItem->annotation, 90) as $t) {
                    $page->setFont($this->_font, 12);
                    $page->drawText($t, $this->_x, $this->_y);
                    $this->_y -= 13;
                }
                    if($this->_y < 85 ){
                        //$page->drawText($this->_y." ".$t, $this->_x, $this->_y-=150);
                        $this->_y -= 13;
                        $page = $this->_newPage($poster);
                        
                    }
                    
                    

                
           //}
           

           $run = false;
               //$this->_pdf->pages[] = $page;
           $i++;

       }
        header("Content-Disposition: inline; filename=$file");
        header("Content-type: application/pdf");
        echo $this->_pdf->render();  exit;
      }
     private function _newPage($poster){
        $this->_x = 50;
        $this->_y = 780;
        $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
           $page->setFont($this->_bfont, 14);
           $page->drawText($poster->title, $this->_x, $this->_y);
           $this->_y -= 12;
           $page->drawLine($this->_x, $this->_y, $this->_x + 495, $this->_y - 2);
           $this->_y -= 12;
    
           $this->_pdf->pages[] = $page;
           return $page;


    }
    private function _getTempFilename($prefix, $count)
    {
          return $prefix . '-part' . $count . '.pdf';
    }
    private function _posterTitle($poster, $page)
    {   
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 14);
        $page->drawText($poster->title,50,760);
        $page->drawLine(50,755,545,755);

     }
    private function _posterDesc($poster, $page,&$x ,&$y)
    {
        $title = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);
        $page->drawText("Description: ",$x, $y);
        $y = $y - 20;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
        $txtArr = $this->_cleanText($poster->description, 90);
        $i = 0;
        $yaxis = $y;
        foreach($txtArr as $t){
            $page->drawText($t,$x,$y, 'UTF-8');
            $y = $y - 13;   
            $i++;
        }
        $y = $y-7;
        $page->setFont($title,13);
        $page->drawText("Poster Items: ",$x, $y);
        $y = $y-20;
        //$this->_posterItems($page,$poster,$x, $y);
       
        //$page->drawText($this->_cleanText($poster->description),50,730, 'UTF-8');
        //exit;
        //$page->drawLine(50,755,50,755);
        
    }

     private function _posterItems($page, $poster,$x, $y)
     {
         $pages = array();
         $pages[] = $page;
       
        $title = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $page->setFont($title, 10);
        
                
        foreach($poster->Items as $item){
            $y = $y- 13;
            foreach($this->_cleanText(metadata($item, array('Dublin Core','Title')), 90) as $t){
                $page->drawText($t,$x, $y);
                $y = $y - 12;
            }
            $y2= $y;
            
             if(metadata($item, 'has files')){
                 $i = 0;
                 foreach($item->Files as $file){
                    if($file->hasThumbnail()){
                        $imgSrc = FILES_DIR."/".$file->getStoragePath();                      
                        $image = Zend_Pdf_Image::imageWithPath($imgSrc);
                        $y2 = $y - 110;//image, x1, y1,    x2, y2
                        $page->drawImage($image, $x,$y2,($x + 150), $y);
                        $page->drawText("",$x, $y);
                        $y = $y- 10;
                        $page->drawText("$y    $y2",$x,($y2 - 10));
                        $y = $y - 110;
                        
                        //$page->drawText("$y    $y2",$x,487);
                    }
                }
             }
         }
     }
    private function _cleanText($txt, $wc)
    {
        $txt = wordwrap($txt, $wc, "<br>\n", true); 
        $txt  = preg_replace(array('/<p>/','/<\/p>/'), '', $txt);
        $txtArr = explode("<br>", $txt);
        return $txtArr; 
    }
}
