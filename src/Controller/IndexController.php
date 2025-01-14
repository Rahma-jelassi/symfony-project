<?php
// src/Controller/IndexController.php

namespace App\Controller;
use App\Form\ReservationType;  // Add this if you're using a form type
use App\Entity\Reservation;


use App\Entity\Room;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class IndexController extends AbstractController
{
    private $entityManager;
    private $mailer;

   
    // Injection de l'EntityManager via le constructeur
    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }


    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $images = [
            'hall1.jpg', 'hall2.jpg', 'hall3.jpg', 'hall4.jpg', 'hall5.jpg',
        ];
        $spaImages = [
            'spa3.jpg', 'spa4.jpg', 'spa5.jpg', 'spa6.jpg', 'spa7.jpg',
        ];

        return $this->render('homepage/index.html.twig', [
            'spaImages' => $spaImages,
        ]);
    }

    /**
     * @Route("/client/rooms", name="client_rooms")
     */
    public function rooms(Request $request, RoomRepository $roomRepository): Response
    {
        $minPrice = $request->query->get('min_price', 0);
        $maxPrice = $request->query->get('max_price', 1000);

        $rooms = $roomRepository->createQueryBuilder('r')
        ->andWhere('r.price BETWEEN :minPrice AND :maxPrice')
        ->setParameter('minPrice', $minPrice)
        ->setParameter('maxPrice', $maxPrice)
        ->getQuery()
        ->getResult();



        return $this->render('client/rooms.html.twig', [
            'rooms' => $rooms,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }

    /**
     * @Route("/room/{id}", name="client_room_details")
     */
    public function roomDetails(int $id): Response
    {
        // Utiliser l'EntityManager pour récupérer la chambre par son ID
        $room = $this->entityManager->getRepository(Room::class)->find($id);

        // Si la chambre n'existe pas, afficher une erreur
        if (!$room) {
            throw $this->createNotFoundException('La chambre demandée n\'existe pas.');
        }

        return $this->render('client/room_details.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/photos", name="photos")
     */
    public function photos(): Response
    {
        $photos = [
            'hall1.jpg', 'hall2.jpg', 'hall3.jpg', 'hall4.jpg', 'hall5.jpg', 'hall6.jpg',
            'hotel1.jpg', 'hotel2.jpg', 'hotel5.jpg', 'spa3.jpg', 'spa4.jpg', 'spa5.jpg',
            'spa6.jpg', 'spa7.jpg', 'rooftop1.jpg', 'resto1.jpg', 'pool1.jpg', 'club1.jpg',
            'room1.jpg', 'room2.jpg', 'room3.jpg', 'room4.jpg', 'room5.jpeg', 'meet2.jpg',
            'meet3.jpg', 'meet4.jpg', 'meet5.jpg',
        ];

        return $this->render('client/photo.html.twig', [
            'photos' => $photos,
        ]);
    }
    
    public function reservation(int $roomId, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification de la disponibilité de la chambre
        $room = $entityManager->getRepository(Room::class)->find($roomId);
    
        if (!$room) {
            throw $this->createNotFoundException('Chambre non trouvée');
        }
    
        // Créer le formulaire de réservation
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $reservation->setRoom($room);
            $reservation->setCreatedAt(new \DateTime());
            $reservation->setUpdatedAt(new \DateTime());
    
            // Récupérer les dates de début et de fin
            $startDate = $reservation->getStartDate();
            $endDate = $reservation->getEndDate();
    
            // Vérifier que les dates ne sont pas dans le passé
            $today = new \DateTime();
            if ($startDate < $today || $endDate < $today) {
                $this->addFlash('error', 'Vous ne pouvez pas réserver une chambre avec des dates dans le passé.');
                return $this->render('reservation/form.html.twig', [
                    'form' => $form->createView(),
                    'room' => $room,
                    'amount' => 0,
                ]);
            }
    
            // Vérifier si la chambre est déjà réservée pendant cette période
            $existingReservation = $entityManager->getRepository(Reservation::class)
                ->createQueryBuilder('r')
                ->andWhere('r.room = :room')
                ->andWhere('r.startDate < :endDate')
                ->andWhere('r.endDate > :startDate')
                ->setParameter('room', $room)
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate)
                ->getQuery()
                ->getOneOrNullResult();
    
            if ($existingReservation) {
                $this->addFlash('error', 'La chambre est déjà réservée pour cette période. Veuillez choisir une autre date.');
                return $this->render('reservation/form.html.twig', [
                    'form' => $form->createView(),
                    'room' => $room,
                    'amount' => 0,
                ]);
            }
    
            // Calculer le montant
            $interval = $startDate->diff($endDate);
            $nights = $interval->days;
            $amount = $nights * $room->getPrice();
            $reservation->setAmount($amount);
    
            // Sauvegarder la réservation
            $entityManager->persist($reservation);
            $entityManager->flush();
    
            $this->addFlash('success', 'Votre réservation a été confirmée.');
            return $this->redirectToRoute('reservation_success', ['id' => $roomId]);
        }
    
        // Calcul pour l'affichage du montant
        $amount = 0;
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            if ($startDate && $endDate) {
                $interval = $startDate->diff($endDate);
                $nights = $interval->days;
                $amount = $nights * $room->getPrice();
            }
        }
    
        return $this->render('reservation/form.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
            'amount' => $amount,
        ]);
    }
    
#[Route('/reservation/{id}/success', name: 'reservation_success')]
public function success(int $id): Response
{
    return $this->render('reservation/success.html.twig', [
        'id' => $id
    ]);
}



}