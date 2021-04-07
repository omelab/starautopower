<?php 
namespace App;

/**
* class SendSMS to send SMS on Mobile Numbers.
* @author Abu Bakar Siddique
*/
class SendSMS
{	 
	private $API_TOKEN;
	private $SID;
	private $DOMAIN;

 	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->API_TOKEN = "StarAuto-1e22baee-51cd-4ad4-bf42-2cef5d0038c1";
        $this->SID = 'STARAUTOPOWERNONBULK';
        $this->DOMAIN = "https://smsplus.sslwireless.com";
    }

 	//send mail
	public function MailSend($to, $message) { 
		//mail(to,subject,message,headers,parameters); 
		//$headers = "From: info@omelab.net" . "\r\n" . "CC: a.bakar87@gmail.com";
		$subject = "Email Notification";  
		$headers = "From: info@starautopower.com";
		return true;

		mail($to,$subject,$message,$headers);
		return 'success';
 	}

 	//send sms
 	public function MessageSend($msisdn, $messageBody) {   
		$csmsId = date('ymdhis'); // csms id must be unique 
		return self::singleSms($msisdn, $messageBody, $csmsId); 
 	}
 
	/**
	 * @param $msisdn
	 * @param $messageBody
	 * @param $csmsId (Unique)
	 */
	function singleSms($msisdn, $messageBody, $csmsId)
	{
	    $params = [
	        "api_token" => $this->API_TOKEN,
	        "sid" => $this->SID,
	        "msisdn" => $msisdn,
	        "sms" => $messageBody,
	        "csms_id" => $csmsId
	    ];
	    $url = trim($this->DOMAIN, '/')."/api/v3/send-sms";
	    $params = json_encode($params);

	    return self::callApi($url, $params);
	}


	function callApi($url, $params)
	{
	    $ch = curl_init(); // Initialize cURL
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params),
	        'accept:application/json'
	    ));

	    $response = curl_exec($ch);

	    curl_close($ch);

	    return $response;
	}

}

 