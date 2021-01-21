<?php

$ch = curl_init("https://www.ah.nl/mijn/inloggen");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
$response = curl_exec($ch);


$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();
$tags = $dom->getElementsByTagName('meta');
for ($i = 0; $i < $tags->length; $i++) {
    $grab = $tags->item($i);
    if ($grab->getAttribute('name') === 'csrf-token') {
        $token = $grab->getAttribute('content');


        $data = array(
            "password" => "Password",
            "recaptchaToken" => $token,
            "username" => "test@test.com"
        );

        curl_setopt($ch, CURLOPT_URL,"https://www.ah.nl/mijn/inloggen" );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) print curl_error($ch);
        curl_close($ch);

    }
}
echo $response;

?>
