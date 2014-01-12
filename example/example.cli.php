<?php
use AlanPich\PhantomPDF\MultiPagePDF;
use AlanPich\PhantomPDF\PDFFactory;
use AlanPich\PhantomPDF\Phantom;

define('ROOT',dirname(dirname(__FILE__)));
require ROOT.'/vendor/autoload.php';


/**
 * Create the phantomjs wrapper
 *
 * @var Phantom $phantomjs
 */
$phantomjs = new Phantom('/usr/bin/phantomjs');

/**
 * Create a PDF Factory
 *
 * @var PDFFactory $pdfFactory;
 */
$pdfFactory = new PDFFactory($phantomjs,array(
    'cache_dir' => ROOT.'/example/cache',
));


/**
 * Create a PDF object
 */
$pdf = $pdfFactory->createPDF();
$pdf->addPage('http://www.smashingmagazine.com/2013/12/27/open-sourcing-projects-guide-getting-started/')
    ->addPage('https://gist.github.com/alanpich/b5f25f1d2bb38ae92811')
    ->addPage('https://gist.github.com/alanpich/625a5ff6e91c9b549d27');
$pdfFactory->generate($pdf,ROOT.'/example/example.pdf');
$pdfFactory->clearCache();