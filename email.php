<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1);

// $nome = $_POST['nome'];
// $email= $_POST['email'];
// $mensagem= $_POST['mensagem'];
// $to = "lucas.nishi@hotmail.com";
// $assunto = 'Nome: '.$nome.'<br>Email:'.$email.'<br><br>'.$_POST['assunto'];
// $headers = "From:{$email}" . "\r\n" .
// "CC: lucas.nishimura@hotmail.com";

// if (mail($to,$assunto,$mensagem,$headers)) {
//     echo("Message successfully sent");
// } else {
//     echo("Message sending failed");
// }

// die();
require __DIR__ . '/vendor/autoload.php';

use \DrewM\MailChimp\MailChimp;

$mc = new MailChimp('22a7b32dcec084e4edc9c11896e21ef8-us20');
// list ID
// When a user unsubscribes from the list, they cannot be subscribed again
// via the API, so use a unique list for this mailing purpose
// $list_id = 'fb05b906b8';
// $list_id = '47085';
$list_id = '41d309ce58';
$email_address = 'lucas.nishi@hotmail.com'; // where to send
$template_id = 22413; // input your template ID

$subject = 'Hello there!';
$message = '<h2>Hooray!</h2><p>It worked!</p>';
$from_name = 'From Name';
$from_email = 'you@yours.com';
# 0. subscribe user if not subscribed
$subscriber_hash = $mc->subscriberHash( $email_address );
$result = $mc->get("lists/{$list_id}/members/{$subscriber_hash}");
// pre($subscriber_hash);

if ( ! isset( $result['status'] ) || 'subscribed' !== $result['status'] ) {
    $result = $mc->post("lists/{$list_id}/members", [
        'email_address' => $email_address,
        'status'        => 'subscribed',
        ]);
    }
// pre($result);
// Check if user subscribed
// $is_subscribed = isset($result['status']) && 'subscribed' === $result['status'];
# 1. create campaign
$result = $mc->post('campaigns', [
    'type' => 'regular',
    'recipients' => [
        'list_id' => $list_id,
        'segment_opts' => [
            'match' => 'all',
            'conditions' => [
                [
                    'condition_type' => 'EmailAddress',
                    'field' => 'EMAIL',
                    'op' => 'is',
                    'value' => $email_address
                ]
            ]
        ],
    ],
    'settings' => [
        'subject_line' => $subject,
        'from_name' => $from_name,
        'reply_to' => $from_email,
        'template_id' => $template_id,
    ],
]);
if ( ! isset( $result['id'] ) || ! $result['id'] )
    return;
$campaign_id = $result['id'];
// 2. update campaign
$result = $mc->put("campaigns/{$campaign_id}/content", [
    'template' => [
        'id' => $template_id,
        'sections' => [
            'std_content00' => $message
        ]
    ],
]);
// 3. send campaign
$result = $mc->post("campaigns/{$campaign_id}/actions/send");
$success = is_bool($result) && $result;


die('oi');




header("Location: https://lucasnishi.herokuapp.com/obrigado.html");
die();

function pre($array,$bool = false){
    echo '<pre>';
    if($bool){
        var_dump($array);
    }else{
        print_r($array);
    }
    echo '</pre>';
    die();
}

?>