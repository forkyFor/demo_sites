<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$name    = trim(strip_tags($_POST['name']    ?? ''));
$email   = trim(strip_tags($_POST['email']   ?? ''));
$company = trim(strip_tags($_POST['company'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

if (!$name || !$email || !$message) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Campi obbligatori mancanti']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Email non valida']);
    exit;
}

$to      = 'contacts@fluxspire.it';
$subject = '=?UTF-8?B?' . base64_encode('Nuovo contatto dal sito — ' . $name) . '?=';

$body  = "Nuovo messaggio dal sito FluxSpire\n";
$body .= str_repeat('-', 40) . "\n\n";
$body .= "Nome:    $name\n";
$body .= "Email:   $email\n";
if ($company) $body .= "Azienda: $company\n";
$body .= "\nMessaggio:\n$message\n";

$headers  = "From: contacts@fluxspire.it\r\n";
$headers .= "Reply-To: $name <$email>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

$params = '-f contacts@fluxspire.it';

$sent = mail($to, $subject, $body, $headers, $params);

if ($sent) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Errore nell\'invio. Scrivici direttamente a contacts@fluxspire.it']);
}
