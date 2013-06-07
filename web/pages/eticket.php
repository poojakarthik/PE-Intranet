<?php
include("../auth/restrict_inner.php");

$session_id="";
if (isset($_COOKIE["otrs_token"]))
{
	$session_id = $_COOKIE["otrs_token"];
}
//SOAP Start
$uname = "pe_intranet";
$pword = "18450be";
$url = "http://192.168.103.26/otrs/intranet_rpc.pl"; # replace with your own otrs url

# initialising soap client
$soapclient = new SoapClient(null,array('location'  => $url,
							 'uri'		 => "Core",
                             'trace'     => 1,
                             'login'     => $uname,
                             'password'  => $pword,
                             'style'     => SOAP_RPC,
                             'use'       => SOAP_ENCODED));

//SOAP End
try{
$soapclient->__call('Dispatch', array($uname, $pword, "LayoutObject", "Output","TemplateFile","AgentDashboard"));
}
catch(Exception $e)
{
	echo $e;	
}
?>
<!--<iframe src='http://192.168.103.26/otrs/index.pl?AgentInterface=<?php echo $session_id;?>' width='100%' margin-bottom='40px' height='650px' frameborder='0' allowtransparency='true' marginwidth='0' marginheight='0' style='display: block;margin-bottom: 29px;background: none repeat scroll 0% 0% transparent; top:0; left:0; width: 100%;'></iframe>-->
        