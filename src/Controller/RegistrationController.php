<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\EnterpriseType;
use DateTime;
use App\Entity\Consumer;
use App\Entity\Expert;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_role")
     */
    public function role()
    {
        if (isset($_POST['submit'])) {
            if ($_POST['roles'] == 'ROLE_CONSUMER') {
                return $this->redirectToRoute('app_register_consumer');
            } elseif ($_POST['roles'] == 'ROLE_EXPERT') {
                return $this->redirectToRoute('app_register_expert');
            } elseif ($_POST['roles'] == 'ROLE_ENTERPRISE') {
                return $this->redirectToRoute('app_register_enterprise');
            }
        }
        return $this->render('registration/role.html.twig');
    }

    /**
     * @Route("/register/consumer", name="app_register_consumer")
     */
    public function consumerregister(Request $request, UserPasswordEncoderInterface
    $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): ?Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $date = new DateTime($_POST['date']);
            $date->format('Ymd');
            $geo = $_POST['geo'];

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_CONSUMER","ROLE_USER"]);

            $consumer = new Consumer();
            $consumer->setUser($user);
            $consumer->setGeographicArea($geo);
            $consumer->setBirthDate($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consumer);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/consumer.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/expert", name="app_register_expert")
     */
    public function expertregister(Request $request, UserPasswordEncoderInterface
    $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): ?Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structure = $_POST['structure'];

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_EXPERT","ROLE_USER"]);

            $expert = new Expert();
            $expert->setUser($user);
            $expert->setConnectingStructure($structure);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expert);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/expert.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/enterprise", name="app_register_enterprise")
     */
    public function enterpriseregister(Request $request, UserPasswordEncoderInterface
    $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): ?Response
    {
        $etptype = $this->getDoctrine()
            ->getRepository(EnterpriseType::class)
            ->findAll();
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etpname = $_POST['etp_name'];
            $fct = $_POST['contact_function'];
            $siret = $_POST['SIRET'];
            $typeid = $_POST['type'];
            $type = $this->getDoctrine()
                ->getRepository(EnterpriseType::class)
                ->findOneBy(['id' => $typeid]);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_ENTERPRISE","ROLE_USER"]);

            $enterprise = new Enterprise();
            $enterprise->setUser($user);
            $enterprise->setName($etpname);
            $enterprise->setContactFunction($fct);
            $enterprise->setSiret($siret);
            $enterprise->setType($type);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enterprise);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/form.html.twig', [
            'registrationForm' => $form->createView(),
            'types' => $etptype
        ]);
    }
}
