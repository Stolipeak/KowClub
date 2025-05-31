<?php
// Configuration des en-têtes pour éviter les problèmes d'encodage
header('Content-Type: text/html; charset=utf-8');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $subject = $_POST['subject'];
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // Récupérer les champs de réservation si nécessaire
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $guests = isset($_POST['guests']) ? $_POST['guests'] : '';

    // Adresse email où vous souhaitez recevoir les demandes
    $to = "sifchahine086@gmail.com"; // Remplacez par votre adresse email

    // Création du sujet de l'email
    $email_subject = "Nouvelle demande - KOW Club";
    if ($subject == "reservation") {
        $email_subject = "Nouvelle réservation - KOW Club";
    } elseif ($subject == "event") {
        $email_subject = "Nouvelle demande d'événement - KOW Club";
    }

    // Création du contenu de l'email
    $email_body = "Nouvelle demande reçue :\n\n";
    $email_body .= "Type de demande : " . $subject . "\n";
    $email_body .= "Nom : " . $name . "\n";
    $email_body .= "Prénom : " . $firstname . "\n";
    $email_body .= "Email : " . $email . "\n";
    $email_body .= "Téléphone : " . $phone . "\n";

    if ($subject == "reservation" || $subject == "event") {
        $email_body .= "Date : " . $date . "\n";
        $email_body .= "Heure : " . $time . "\n";
        $email_body .= "Nombre de personnes : " . $guests . "\n";
    }

    if (!empty($message)) {
        $email_body .= "\nMessage : \n" . $message . "\n";
    }

    // En-têtes de l'email
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Envoi de l'email
    if (mail($to, $email_subject, $email_body, $headers)) {
        $response = array(
            'success' => true,
            'message' => 'Votre demande a été envoyée avec succès !'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Une erreur est survenue lors de l\'envoi de votre demande.'
        );
    }

    // Renvoyer la réponse en JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
