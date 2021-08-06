<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\form\SubscriberType;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;




class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home/createform", name="app_subscriber")
     */
    public function indexx(Request $request, ObjectManager $manager): Response
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(AnnounceType::class, $subscriber);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'image depuis le formulaire
            $photo = $form->get('photo')->getData();
            if ($photo) {
                //création d'un nom pour l'image avec l'extension récupérée
                $photoName = md5(uniqid()) . '.' . $photo->guessExtension();

                //on déplace l'image dans le répertoire cover_image_directory avec le nom qu'on a crée
                $photo->move(
                    $this->getParameter('photo_directory'),
                    $photoName
                );

                // on enregistre le nom de l'image dans la base de données
                $subscriber->setPhoto($photoName);
            }
            
            $manager->persist($subscriber);
            $manager->flush();

            return $this->redirectToRoute('app_subscriber');
        }

        return $this->render('home/createform.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
