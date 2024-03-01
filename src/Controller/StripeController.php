<?php
 
namespace App\Controller;
 
use App\Entity\Produit;
use App\Repository\ComposerRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;
use App\Repository\UserRepository;
use App\Repository\AdresseRepository;

 
class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(Request $request, Security $security, UserRepository $userRepository, ComposerRepository  $composersRepository,PanierRepository $panierRepository, AdresseRepository $adresseRepository): Response
    {
        $user = $security->getUser();
        $adresses = $adresseRepository->findBy(
            ['user' =>  $security->getUser()->getId() ],

        );
        
        $panierUserEnCours = $panierRepository->findOneBy(
            ['user' => $user->getId(), 'etat' => '1'],
        );

        $composers = $panierUserEnCours->getComposers();
            $composers->initialize();
            $composers->toArray();

            $total = 0;
            foreach ($composers as $composer){

                $total +=  ($composer->getQuantite()*$composer->getIdPro()->getPrixPro());
            }
            
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'total' => $total,
            'user' => $user,
            'adresses' => $adresses,
        ]);
    }
 
 
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, Security $security, ComposerRepository  $composersRepository,PanierRepository $panierRepository)
    {
        $user = $security->getUser();

        $panierUserEnCours = $panierRepository->findOneBy(
            ['user' => $user->getId(), 'etat' => '1'],
        );
        
        $composers = $panierUserEnCours->getComposers();
            $composers->initialize();
            $composers->toArray();

            $total = 0;
            foreach ($composers as $composer){

                $total +=  ($composer->getQuantite()*$composer->getIdPro()->getPrixPro());
            }
            // dd($total);
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => $security->getUser()->getEmail() . " " . $security->getUser()->getId(),
        ]);
        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }

    
}
