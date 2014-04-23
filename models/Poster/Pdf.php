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
        echo $this->_pdf->render(); exit;
        $this->_pdf->save($file);
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
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);
        $page->drawText("Description: ",50, 740);
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
        $txtArr = $this->_cleanText($poster->description, 80);
        $i = 0;
        foreach($txtArr as $t){
            $page->drawText($t,50,(730 - (13*$i)), 'UTF-8');
            $i++;
        }
        //$page->drawText($this->_cleanText($poster->description),50,730, 'UTF-8');
        //exit;
        //$page->drawLine(50,755,50,755);
        
    }

     private function _posterItems($poster)
     {

     }
    private function _cleanText($txt, $wc)
    {
        $txt = wordwrap($txt, $wc, "<br>\n", true); 
        $txt  = preg_replace(array('/<p>/','/<\/p>/'), '', $txt);
        $txtArr = explode("<br>", $txt);
        return $txtArr; 
    }
}
