<?php
require 'func.inc.php';

// Setup
$to='info@calimasystems.com';
$cco='info@calimastudio.es';

// Get fields
$name   =$_REQUEST['name'];
$phone  =$_REQUEST['phone'];
$email  =$_REQUEST['email'];
$textarea=$_REQUEST['textarea'];

$aceptar=$_REQUEST['conds'];

$subject="[CalimaSystems] Formulario de contacto".$name;

if (!empty ($aceptar))
$aceptar='He leído lo relativo a protección de mis datos y estoy conforme';

$message = '<html><body>';
$message .= 'CalimaSystems';

$message .='<br /><br />';
$message .='<p>Gracias por contactar con <strong>CalimaSystems</strong>.</p>';
$message .='<p>Le responderemos en el menor plazo de tiempo posible.</p>';
$message .='<br /><br />';
$message .="<p><a href='http://www.calimasystems.com'>CalimaSystems C.B.</a><p>";
$message .='<br /><br />';

$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
$message .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
$message .= "<tr style='background: #eee;'><td><strong>Tel&eacute;fono:</strong> </td><td>" . strip_tags($phone) . "</td></tr>";
$message .= "<tr style='background: #eee;'><td><strong>Mensaje:</strong> </td><td>" . strip_tags($textarea) . "</td></tr>";

$message .="</table>";

$body=$message;

/*$subject=utf8_decode($subject);
$body=utf8_decode($body);*/

//$subject=iconv("UTF-8", "ISO-8859-1", $subject);
$body   =iconv("UTF-8", "ISO-8859-1", $body);

$headers .= "MIME-Version: 1.0\r\n";
//	$headers .= "Content-type: text/plain; charset=utf-8\r\n";
$headers .= "From: ".strip_tags($email)."\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

// Validación Formulario: Requerimos nombre, email y textarea
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['textarea']) ) {
	$vars="name=".$_POST['name']."&phone=".$_POST['phone']."&email=".$_POST['email']."&textarea=".$_POST['textarea']."&error";
	header ("Location: http://www.calimasystems.com/index.html?$vars");
}
else {
	if (mail($to, $subject, $body, $headers))
	  mail ($cco, $subject, $body, $headers);
	else
	  echo "Email NO enviado.<br /> Póngase en contacto con info@calimastudio.es";
	// Redirect to site
	header ("Location: http://www.calimasystems.com/thankyou.html");
}
?>
