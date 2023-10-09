<?php 

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendMail($userEmail, $subject, $message) {
        $email = (new TemplatedEmail())
            ->from('mail@example.com')
            ->to('thedistrict@example.com')
            ->subject($subject)
            ->htmlTemplate('emails/contact_email.html.twig')
            ->context([
                'mail' => $userEmail,
                'subject' => $subject,
                'message' => $message,
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'The District',
            ]);

        $this->mailer->send($email);
    }

    public function sendOrderConfirmationMail($userData, $orderData) {
        $email = (new TemplatedEmail())
            ->from('mail@example.com')
            ->to($userData['email'])
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('emails/order_confirmation.html.twig')
            ->context([
                'username' => $userData['username'],
                'panier' => $orderData['panier'],
                'total' => $orderData['total'],
                'adresseLivraison' => $orderData['adresseLivraison'],
                'codePostalLivraison' => $orderData['codePostalLivraison'],
                'villeLivraison' => $orderData['villeLivraison'],
            ]);
    
        $this->mailer->send($email);
    }
    
}
