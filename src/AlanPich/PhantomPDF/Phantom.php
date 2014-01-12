<?php
namespace AlanPich\PhantomPDF;

/**
 * API Wrapper for phantomjs
 *
 * @package AlanPich\PhantomPDF
 */
class Phantom
{
    protected $phantomjs;


    public function __construct($phantom_path,$opts=array())
    {
        $this->setPhantomJsExecutablePath($phantom_path);
    }


    /**
     * Execute a phantomJs script
     *
     * @param string $script
     * @param array  $arguments
     * @throws \Exception
     * @return string
     */
    public function run($script,$arguments = array())
    {
        // Check script exists
        if(!is_readable($script))
            throw new \Exception("Script {$script} does not exist");

        $cmd = "{$this->phantomjs} {$script}";
        if(count($arguments)){
            $cmd.= ' '.implode(" ",$arguments);
        }
        return shell_exec($cmd);
    }


    /**
     * Shortcut method to create a PDF from a url
     *
     * @param string $url
     * @param string $outputPath
     * @throws \Exception
     * @return string
     */
    public function urlToPdf($url,$outputPath)
    {
        $script = dirname(__FILE__).'/url-to-pdf.js';
        $args = array(
            $url,
            $outputPath,
            'A4'
        );

        return $this->run($script,$args);
    }


    /**
     * @param mixed $phantomjs
     */
    public function setPhantomJsExecutablePath($phantomjs)
    {
        $this->phantomjs = $phantomjs;
    }

    /**
     * @return mixed
     */
    public function getPhantomJsExecutablePath()
    {
        return $this->phantomjs;
    }




} 