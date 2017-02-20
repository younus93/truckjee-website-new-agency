<?php

# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-4959e8d40b417c1997416d044bceb271');
$domain = "sandbox3f48735962434013b701248fce6217da.mailgun.org";

$name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = strip_tags(trim($_POST["phone"]));
        $type = strip_tags(trim($_POST['type']));
if(empty($name) OR empty($email) OR empty($phone) OR empty($type))
{
	http_response_code(403);
	echo "Unable to process. Please enter all required details";
	exit;
}
# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Website Enquiry <mailgun@sandbox3f48735962434013b701248fce6217da.mailgun.org>',
    'to'      => 'Younus <itsme@theyounus.com>',
    'subject' => 'New Website Enquiry',
    'text'    => "$name - $email - $phone - $type - ".date('d/m/Y')
));
$txt = "$name - $phone - $email - $type - ".date('d/m/Y');
$myfile = file_put_contents('logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

if($result){
http_response_code(200);
 echo "Thank you. We will get back to you shortly";

}
else{
 http_response_code(500);
 echo "Unable to connect to our servers. Write to us at info@truckjee.com";
}

