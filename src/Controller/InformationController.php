<?php

namespace App\Controller;

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
                ->to('wcs.brandvisor@gmail.com')
                    ->subject($_POST['subject'])
                    ->htmlTemplate('email/contact.html.twig')
                    ->context([
                        "name"=>$name,
                        "mail"=>$_POST['email'],
                        "description"=>$_POST['description']
                    ]);
                $mailer->send($email);
            } else {
                echo "Veuillez remplir les champs obligatoires.";
            }
        }
        return $this->render('/information/index.html.twig');
    } }