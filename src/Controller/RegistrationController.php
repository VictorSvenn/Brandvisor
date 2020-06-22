<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\EnterpriseType;
use App\Form\ConsumerRegistrationFormType;
use App\Form\ExpertRegistrationFormType;
use DateTime;
use App\Entity\Consumer;
use App\Entity\Expert;
use App\Entity\User;
use App\Form\EtpRegistrationFormType;
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
    public function consumerregister(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                                     GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator)
    : ?Response
    {
        $user = new User();
        $form = $this->createForm(ConsumerRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() and $_POST['date'] != '' and $_POST['geo'] != '') {
            // encode the plain password
            $date = new DateTime($_POST['date']);
            $date->format('Ymd');
            $geo = $_POST['geo'];

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_CONSUMER", "ROLE_USER"]);

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
        if ($form->isSubmitted()) {
            if ($_POST['date'] === '') {
                $errorDate = 1;
            } else {
                $errorDate = 0;
            }
            if ($_POST['geo'] === '') {
                $errorGeo = 1;
            } else {
                $errorGeo = 0;
            }

            return $this->render('registration/consumer.html.twig', [
                'registrationForm' => $form->createView(),
                'errorDate' => $errorDate,
                'errorGeo' => $errorGeo
            ]);
        }

        return $this->render('registration/consumer.html.twig', [
            'registrationForm' => $form->createView(),
            'errorDate' => 0,
            'errorGeo' => 0
        ]);
    }

    /**
     * @Route("/register/expert", name="app_register_expert")
     */
    public function expertregister(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                                   GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator)
    : ?Response
    {
        $user = new User();
        $form = $this->createForm(ExpertRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() and $_POST['structure'] != '') {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_EXPERT", "ROLE_USER"]);

            $expert = new Expert();
            $expert->setUser($user);
            $structure = $_POST['structure'];
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
        if ($form->isSubmitted() and $_POST['structure'] === '') {
            $errorStrucure = 1;
            return $this->render('registration/expert.html.twig', [
                'registrationForm' => $form->createView(),
                'errorstructure' => $errorStrucure
            ]);
        }
        return $this->render('registration/expert.html.twig', [
            'registrationForm' => $form->createView(),
            'errorstructure' => 0
        ]);
    }

    /**
     * @Route("/register/enterprise", name="app_register_enterprise")
     */
    public function enterpriseregister(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                                       GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator)
    : ?Response
    {
        $etptype = $this->getDoctrine()
            ->getRepository(EnterpriseType::class)
            ->findAll();
        $user = new User();
        $form = $this->createForm(EtpRegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() and $form->get('etpname')->getData() != '' and
            $form->get('contact_fct')->getData() != '' and $form->get('SIRET')->getData() != '') {
            $name = $form->get('etpname')->getData();
            $fct = $form->get('contact_fct')->getData();
            $siret = $form->get('SIRET')->getData();
            $typeid = $_POST['type'];
            $type = $this->getDoctrine()
                ->getRepository(EnterpriseType::class)
                ->findOneBy(['id' => $typeid]);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_ENTERPRISE", "ROLE_USER"]);

            $enterprise = new Enterprise();
            $enterprise->setUser($user);
            $enterprise->setName($name);
            $enterprise->setContactFunction($fct);
            $enterprise->setSiret((int)$siret);
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
        if ($form->isSubmitted()) {
            if ($form->get('etpname')->getData() == '') {
                $errorname = 1;
            } else {
                $errorname = 0;
            }
            if ($form->get('SIRET')->getData() == '') {
                $errorsiret = 1;
            } else {
                $errorsiret = 0;
            }
            if ($form->get('contact_fct')->getData() == '') {
                $errorfct = 1;
            } else {
                $errorfct = 0;
            }

            return $this->render('registration/enterprise.html.twig', [
                'registrationForm' => $form->createView(),
                'types' => $etptype,
                'errorname' => $errorname,
                'errorsiret' => $errorsiret,
                'errorfct' => $errorfct,
            ]);
        }

        return $this->render('registration/enterprise.html.twig', [
            'registrationForm' => $form->createView(),
            'types' => $etptype,
            'errorname' => 0,
            'errorsiret' => 0,
            'errorfct' => 0,
        ]);
    }
}
