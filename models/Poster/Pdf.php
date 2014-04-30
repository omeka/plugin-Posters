<?php

class Poster_Pdf //extends Zend_Pdf{
{
    protected $_pdf;
    protected $_template;
    private $_font;
    private $_pageCount = 0;

    const PAGE_HEIGHT = 595;
    const PAGE_WIDTH  = 842;

    const MARGIN_LEFT   = 13.5;
    const MARGIN_RIGHT  = 36;
    const MARGIN_TOP    = 36;
    const MARGIN_BOTTOM = 13.5;


    public function __construct()
    {
        // new pdf file will be created
        // everytime this class is called
        // this behaviour might change
        $tmplt = dirname(__FILE__)."/PdfTemplate.pdf";
        //var_dump($tmplt);
        $this->_pdf = new Zend_Pdf();
        if (file_exists($tmplt)){
            $this->_template = Zend_Pdf::load($tmplt);
        }
    }
    public function generate($poster)
    {

       $file = $poster->title . ".pdf";
       $bfont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
       $font  = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
       $index = 0;
       $makePages = true;
       while($makePages){
           $page = $this->_pdf->newPage(Zend_Pdf_Page::SIZE_A4);
          // 50 is the margin line
           $x = 50;//$page->getWidth();
           //start drawing from th
           $y = 780;//$page->getHeight();
           $page->setFont($bfont, 14);
           $page->drawText($poster->title,$x,$y);
           $y = $y - 12;// y = 778
           $page->drawLine($x,$y, $x+495, $y-1);
           $y = $y-12;//
           if($index === 0){
               
               $this->_posterDesc($poster, $page, $x, $y);
           }
           
      
        $this->_pdf->pages[$index] = $page;
       $makePages = false;
       }
        header("Content-Disposition: inline; filename=$file");
        header("Content-type: application/x-pdf");
        echo $this->_pdf->render();  exit;
        //create the pages object page size = 595:842
       /* $page = $this->_pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $this->_pdf->pages[] = $page;
        $page->setFont(Zend_Pdf_Font::fontWithName(
                Zend_Pdf_Font::FONT_HELVETICA_BOLD
            ),
            14
        );
        $page->drawText($poster->title,50 ,760);
        $page->drawLine(50,755,545,755);
        
        $this->_posterTitle($poster,$page);
        $this->_posterDesc($poster,$page);
        header("Content-Disposition: inline; filename=$file");
        header("Content-type: application/x-pdf");
        echo $this->_pdf->render();  exit;
    //    //$this->_pdf->save($file);*/
    
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
    private function _posterDesc($poster, $page,$x ,$y)
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
        $this->_posterItems($page,$poster,$x, $y);
       
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
