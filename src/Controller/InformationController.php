<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Bridge\Google\TRansport\GmailSmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class InformationController extends AbstractController
{
    /**
     * @Route("/info", name="app_info")
     */
    public function index(MailerInterface $mailer): Response
    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['email']) && !empty($_POST['subject'])) {
                $name = $_POST['firstname']." ".$_POST['lastname'];
                $email = (new TemplatedEmail())
                ->from($_POST['email'])
                ->to('contact@brandvisor.fr')
                    ->subject($_POST['subject'])
                    ->htmlTemplate('email/contact.html.twig')
                    ->context([
                        "name"=>$name,
                        "mail"=>$_POST['email'],
                        "description"=>$_POST['description']
                    ]);
                $mailer->send($email);

                $contact = new Contact();
                $contact->setMessage($_POST['description']);
                $contact->setEmail($_POST['email']);
                $contact->setLastName($_POST['lastname']);
                $contact->setFirstName($_POST['firstname']);
                $contact->setReason($_POST['subject']);
                $entityM = $this->getDoctrine()->getManager();
                $entityM->persist($contact);
                $entityM->flush();
            } else {
                echo "Veuillez remplir les champs obligatoires.";
            }
        }
        return $this->render('/information/index.html.twig');
    }
}
