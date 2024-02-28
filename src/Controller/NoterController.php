<?php

namespace App\Controller;

use App\Entity\Noter;
use App\Repository\NoterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $somme = 0;
        $compteur = 0;

        foreach ($notes as $note) {
            $somme += $note->getNote();
            $compteur++;
        }

        if ($compteur > 0) {
            $moyenne = $somme / $compteur;
        } else {
        }

        $user = $security->getUser();
        if($user){
            $userNote = $noterRepository->findOneBy(
            ['produit' => $idProduit ,'user' =>$user],

            );
            if (!$userNote){
                $userNote="Pas encore noté";
                $userNoteId="Pas encore noté";
            }else{
                $userNote =$userNote->getNote();
                $userNoteId=$userNote->getId();
            }


        }else{
            $userNote = 'null';
        }
       

        $data = [
            'moyenne_note' => $moyenne,
            'user_note' => $userNote,
            'nombre_note' => $compteur,
            'id_produit' => $idProduit,
            'id_note' =>$userNoteId,
         ];
        return new JsonResponse($data);
    }
    #[Route('/api/updatenoteproduit', name: 'app_api_updatenoteproduit', methods: ['PUT'])]
    public function updatenoteproduit(Request $request, EntityManagerInterface $entityManager,Security $security,NoterRepository $noterRepository): Response
    {
        // Récupérer les données de la requête
        $requestData = json_decode($request->getContent(), true);


        $noteValue = $requestData['note'];
        $idProduit = $requestData['id_produit'];

        $user = $security->getUser();
        if($user){
            $note = $noterRepository->findOneBy(
                ['produit' => $idProduit ,'user' =>$user],
            );
            if (!$note){
                $note="Pas encore noté";
            }
        }else{
            $note = 'null';
        }


        if (!$note) {
            return new JsonResponse(['error' => 'Note not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $note->setNote($noteValue);

        $entityManager->flush();

        return new JsonResponse(['status' => 'OK'], JsonResponse::HTTP_OK);
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
