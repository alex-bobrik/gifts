<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordChangeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/manager/password", name="manager_password")
     */
    public function changePasswordManager(Request $request, UserPasswordEncoderInterface $encoder)
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['username' => 'manager']
        );

        // $argon2id$v=19$m=65536,t=4,p=1$9/zCeEoZgWOkbKEqPWfB0g$CUX7JfDs8D6V9mzMULyKGwOFpLJXCgthdbJxSz03/0A
        $form = $this->createForm(PasswordChangeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            $encoded = $encoder->encodePassword($user, $form->get('password')->getData());

            $user->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'Пароль успешно изменен');

            return $this->redirectToRoute('manager_orders');
        }

        return $this->render('security/manager_password.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/password", name="admin_password")
     */
    public function changePasswordAdmin(Request $request, UserPasswordEncoderInterface $encoder)
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['username' => 'admin']
        );

        $form = $this->createForm(PasswordChangeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            $encoded = $encoder->encodePassword($user, $form->get('password')->getData());

            $user->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'Пароль успешно изменен');

            return $this->redirectToRoute('admin_items');
        }

        return $this->render('security/admin_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
