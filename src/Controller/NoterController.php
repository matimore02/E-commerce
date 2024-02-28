<?php

namespace App\Controller;

use App\Entity\Noter;
use App\Repository\NoterRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/noter')]
class NoterController extends AbstractController
{
    
    public function index(): Response
    {
        return $this->render('noter/index.html.twig', [
            'controller_name' => 'NoterController',
        ]);
    }

    #[Route('/api/getnotebyidproduit/{idProduit}', name: 'app_api_getnotebyproduit', methods: ['GET'])]
    public function getNoteByidProduit($idProduit, NoterRepository $noterRepository,Security $security): Response
    {
        $notes = $noterRepository->findBy(
            ['produit' => $idProduit ],

        );
        // dd($notes);
        // Supposons que $notes est un tableau contenant les notes du produit
            // $notes = [4, 5, 3, 5, 4];

        // Initialisation de la somme et du compteur
        $somme = 0;
        $compteur = 0;

        // Parcours des notes avec une boucle foreach
        foreach ($notes as $note) {
            // Ajout de la note à la somme
            $somme += $note->getNote();
            
            
            // Incrémentation du compteur à chaque itération
            $compteur++;
        }

        if ($compteur > 0) {
            $moyenne = $somme / $compteur;
        } else {
        }

        
      
        
        $user = $security->getUser();
        if($user){
            $userNote = $noterRepository->findBy(
            ['produit' => $idProduit ,'user' =>$user],
            ); 
            if (!$userNote){
                $userNote="Pas encore noté";
            }
        }else{
            $userNote = 'null';
        }
       

        $data = [

            'moyenne_note' => $moyenne,
            'user_note' => $userNote,
         ];
        return new JsonResponse($data);
    }

    //#[Route('/api/addnoteproduit', name: 'app_api_addNoteToProduit')]
    //public function addNoteToProduit(Security $security): Response
    //{
//
    //    $data = json_decode($request->getContent());
//
    //        $code = 200;
    //        $user = $security->getUser();
//
    //      
    //        $produitEnCours = $produit->findOneBy(
    //            ['user' => $user->getId(), 'etat' => '1'],
    //        );
    //        
    //        
    //        $produit = $entityManager->getRepository(Note::class)->find($data->note);
    //        $note = new Note;
    //        $note->setNoter($data->noter);
    //        $note->setIdPro($produit);
//
    //    try {
    //        $entityManager->persist($composer);
    //        $entityManager->flush();
    //    } catch (\Exception $exception) {
    //        return new JsonResponse(['success' => false, 'message' => $exception->getMessage()], 500);
    //    }
    //        return new JsonResponse(['status' => 'OK'], $code);
    //}
}
