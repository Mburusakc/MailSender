<?php
// on declare les variables de PHPMailer 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// on importe les fichiers necessaires par rapport a leur chemin relatif 
require_once "./PHPMailer/PHPMailer.php";
require_once "./PHPMailer/SMTP.php";
require_once "./PHPMailer/Exception.php";

// on verifie si les elements du formulaires ont ete recu via une methode
// ici la methode utilisee est le POST
// les differents elements a recevoir sont le nom, l'adresse mail, le numero de telephone, le message, et l'entreprise
// mais biensur tu peux rajouter ou meme supprimer des elements en fonction de tes besoins 
if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = strip_tags(utf8_decode($_POST['name']));
    $email = strip_tags($_POST['email']);
    $phone =  strip_tags($_POST['phone']);
    $company = strip_tags(utf8_decode($_POST['company']));
    $message = strip_tags(utf8_decode($_POST['message']));
    // strip_tags : permet d'enlever d'eventuels codes malveillants fournis
    // utf8_decode : permet de gerer l'encodage des textes recus afin d'eviter d'avoir des caracteres non pris en charge

    // on creer un objet PHPMailer pour pouvoir envoyer un mail
    $mail = new PHPMailer();

    // on configure le serveur d'envoi des mails
    // on valide qu'il s'agit d'un serveur smtp
    $mail->isSMTP();
    // on fourni l'hote du serveur... generalement c'est de type mail.exemple.site
    // il faut remplacer exemple.site par le nom de domaine de ton site 
    $mail->Host = "mail.exemple.site";
    // on specifie qu'il s'agit d'une connection securisee
    $mail->SMTPAuth = true;
    // ici il faut mettre l'adresse mail utilisee sur le site internet (hebergement)
    $mail->Username = "contact@exemple.site";
    // mettre le mot de passe de cette adresse mail
    $mail->Password = 'le mot de passe';
    // on specifie le port
    $mail->Port = 587;
    // et ensuite on specifie le type de secutite utilisee
    $mail->SMTPSecure = "tls";

    // ici on configure le mail en sois
    // on specifie que c'est du html
    // afin de prendre en charge l'affichage du code html pour une meilleure mise en page
    $mail->isHTML(true);
    // on fourni le mail et le nom de la provenance du mail, ces elements ont ete fournis dans le formulaire lors de l'envoi
    $mail->setFrom($email, $name);
    // on entre le mail du destinataire : vers celui que l'on veut envoyer
    $mail->addAddress("exemple@exemple.site");
    // on entre le destinataure vers qui repondre le mail, normalement c'est les memes informations que la provenance du mail
    $mail->addReplyTo($email, $name);
    // ici on entre le sujet su mail
    $mail->Subject = 'le sujet du mail';
    // enfin on entre le corps du mail
    $mail->Body = "De : " . $name . " / " . $email . " / <a href=" . "tel:" . $phone . ">" . $phone . "</a><br/><br/> <strong>Entreprise : " . $company . "</strong> <br/><br/>" . $message;

    if ($mail->send()) {
        // si tout est bon alors 
    } else {
        // si il ya des erreures 
    }
}
