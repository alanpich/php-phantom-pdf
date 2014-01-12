<?php
namespace AlanPich\PhantomPDF;

class PDFFactory
{
    /** @var Phantom  */
    protected $phantom;
    /** @var array  */
    protected $config = array();

    public function __construct( $phantom = null, $config = array() )
    {
        if($phantom instanceof Phantom)
            $this->phantom = $phantom;

        $this->config = array_merge(array(
                'cache_dir' => dirname(__FILE__).'/cache',
            ),$config);

        if(!is_dir($this->config['cache_dir'])){
            try {
                mkdir($this->config['cache_dir']);
            } catch (\Exception $E){
                throw new \Exception("Failed to create cache dir at {$this->config['cache_dir']}");
            }
        }
    }

    /**
     * Create a new PDF abstraction
     * @return PDF
     */
    public function createPDF()
    {
        $pdf = new PDF;
        $pdf->setPhantom($this->phantom);
        return $pdf;
    }

    /**
     * Generate a PDF file
     *
     * @param PDF $pdf
     * @param string $outPath
     */
    public function generate( PDF $pdf, $outPath)
    {
        $cacheDir = $this->config['cache_dir'];
        $files = array();
        foreach($pdf->getPages() as $url){
            $path = $cacheDir.'/'.md5($url).'.pdf';
            $this->phantom->urlToPdf($url,$path);
            $files[] = $path;
        }

        // Page PDFs generated, stitch 'em together
        $composite = new \PDFMerger();
        foreach($files as $file){
            $composite->addPDF($file);
        }

        // Output
        try {
            $composite->merge('file',$outPath);
        }catch (\Exception $E){
            // Throws an exception for no good reason - ignore it
        }
    }

    /**
     * Clean up the PDF cache
     */
    public function clearCache()
    {
        $files = glob($this->config['cache_dir'].'/*.pdf');
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }

    /**
     * @param mixed $phantom
     */
    public function setPhantom($phantom)
    {
        $this->phantom = $phantom;
    }

    /**
     * @return mixed
     */
    public function getPhantom()
    {
        return $this->phantom;
    }



} 