<?php

namespace App\Controller;

namespace App\Controller;



use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\UserRepository;
#[Route('/user')]

class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/show', name: 'app_user_show', methods: ['GET'])]
    public function show(Security $security,UserRepository $userRepository,PanierRepository $panierRepository): Response
    {
        $user = $userRepository->find($security->getUser()) ;
        if(!$user){
            return $this->render('default/index.html.twig', [
                'controller_name' => 'DefaultController',
            ]);
        }

        $nombreCommande = $panierRepository->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.etat = :etat')
            ->andWhere('p.user = :user')
            ->setParameter('etat', 2)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();



        return $this->render('user/index.html.twig', [
            'user' => $user,
            'nombreCommande' => $nombreCommande,
            'adresses' => $user->getAdresses(),
        ]);
    }
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


}
