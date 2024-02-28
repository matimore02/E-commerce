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
    #[Route('/show', name: 'app_user_show', methods: ['GET'])]
    public function show(Security $security,UserRepository $userRepository,PanierRepository $panierRepository): Response
    {
        $user = $userRepository->find($security->getUser()) ;
        if(!$user){
            dd('stop');
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

}
