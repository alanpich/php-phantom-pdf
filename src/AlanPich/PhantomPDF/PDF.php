<?php
namespace AlanPich\PhantomPDF;

class PDF
{
    /** @var  Phantom */
    protected $phantom;

    /** @var array  */
    protected $pages = array();


    /**
     * Add another page to the PDF at specified index
     *
     * @chainable
     * @param string $url Url to use to render the page
     * @param integer $index Position to insert page at
     * @return $this
     */
    public function addPage( $url, $index = -1 )
    {
        if($index>=0){
            $this->pages[$index] = $url;
        } else {
            $this->pages[] = $url;
        }
        return $this;
    }

    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param \AlanPich\PhantomPDF\Phantom $phantom
     */
    public function setPhantom($phantom)
    {
        $this->phantom = $phantom;
    }

    /**
     * @return \AlanPich\PhantomPDF\Phantom
     */
    public function getPhantom()
    {
        return $this->phantom;
    }


} 