<?php defined('BASEPATH') OR exit('No direct script access allowed');
// Dompdf namespace use Dompdf\Dompdf;
class Pdf { 
public function __construct()
{
require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
$options = new Dompdf\Options();
//$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf\Dompdf($options);
$contxt = stream_context_create([
    'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE
    ]
    ]);
$dompdf->setHttpContext($contxt); 
$CI = & get_instance();
$CI->dompdf = $dompdf; 
}

} ?>
