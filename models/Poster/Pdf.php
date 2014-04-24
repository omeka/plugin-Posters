<?php

class Poster_Pdf //extends Zend_Pdf{
{
    protected $_pdf;
    private $_font;
    private $_pageCount = 0;

    const PAGE_HEIGHT = 792;
    const PAGE_WIDTH  = 612;

    const MARGIN_LEFT   = 13.5;
    const MARGIN_RIGHT  = 36;
    const MARGIN_TOP    = 36;
    const MARGIN_BOTTOM = 13.5;


    public function __construct()
    {
        // new pdf file will be created
        // everytime this class is called
        // this behaviour might change
        $this->_pdf = new Zend_Pdf();
    }
    public function generate($poster)
    {

        $file = $poster->title . ".pdf";
        //create the pages object page size = 595:842
        $page = $this->_pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $this->_pdf->pages[] = $page;
        /**$page->setFont(Zend_Pdf_Font::fontWithName(
                Zend_Pdf_Font::FONT_HELVETICA_BOLD
            ),
            14
        );
        $page->drawText($poster->title,50 ,760);
        $page->drawLine(50,755,545,755);
         */
        $this->_posterTitle($poster,$page);
        $this->_posterDesc($poster,$page);
        header("Content-Disposition: inline; filename=$file");
        header("Content-type: application/x-pdf");
        echo $this->_pdf->render();  exit;
        //$this->_pdf->save($file);
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
    private function _posterDesc($poster, $page)
    {
        $title = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);
        $page->drawText("Description: ",50, 740);
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
        $txtArr = $this->_cleanText($poster->description, 80);
        $i = 0;
        $yaxis = 725;
        foreach($txtArr as $t){
            $page->drawText($t,55,(725 - (13*$i)), 'UTF-8');
            $yaxis = $yaxis - 13;   
            $i++;
        }
        $page->setFont($title,13);
        $page->drawText("Poster Items: ",50, $yaxis);
        $this->_posterItems($page,$poster,$yaxis-10);
       
        //$page->drawText($this->_cleanText($poster->description),50,730, 'UTF-8');
        //exit;
        //$page->drawLine(50,755,50,755);
        
    }

     private function _posterItems($page, $poster, $yaxis)
     {
        $y1 = 525-5;
        $y2 = 625-5;
        $title = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $page->setFont($title, 10);
        
                
        foreach($poster->Items as $item){
            $page->drawText(metadata($item, array('Dublin Core','Title')),50, $y2);
            $y1 = $y1 - 13;
            $y2 = $y2 - 13;
             if(metadata($item, 'has files')){
                 $i = 0;
                 foreach($item->Files as $file){
                    if($file->hasThumbnail()){
                        $yaxis = $yaxis - ($i * 100);
                        $imgSrc = FILES_DIR."/".$file->getStoragePath();                      
                        $image = Zend_Pdf_Image::imageWithPath($imgSrc);
                        //                image, x1, y1,    x2, y2
                        $page->drawImage($image, 50,$y1,200, $y2);

                        $y1 = $y1 - 110;
                        $y2 = $y2 - 110;
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
