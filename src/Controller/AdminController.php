<?php
// src/Controller/AdminController.php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin(RoomRepository $roomRepository, ReservationRepository $reservationRepository): Response
    {
        // Récupérer toutes les chambres
        $rooms = $roomRepository->findAll();
        $reservations = $reservationRepository->findAll();

        // Statistiques
        $totalRooms = count($rooms);
        $totalReservations = count($reservations);
        $confirmedReservations = array_filter($reservations, fn($r) => $r->getStatus() === 'confirmed');
        $rejectedReservations = array_filter($reservations, fn($r) => $r->getStatus() === 'rejected');
        $pendingReservations = array_filter($reservations, fn($r) => $r->getStatus() === 'pending');

        // Passer les données des chambres et des réservations à la vue
        // Passer les données des chambres, réservations, et statistiques à la vue
    return $this->render('homepage/admin.html.twig', [
        'rooms' => $rooms,
        'reservations' => $reservations,
        'statistics' => [
            'totalRooms' => $totalRooms,
            'totalReservations' => $totalReservations,
            'confirmedReservations' => count($confirmedReservations),
            'rejectedReservations' => count($rejectedReservations),
            'pendingReservations' => count($pendingReservations),
        ], ]);
    }

    /**
 * @Route("/admin/reservation/{id}/update-status/{status}", name="admin_update_reservation_status")
 */
public function updateReservationStatus(
    int $id,
    string $status,
    EntityManagerInterface $entityManager
): Response {
    // Récupérer la réservation
    $reservation = $entityManager->getRepository(Reservation::class)->find($id);

    if (!$reservation) {
        throw $this->createNotFoundException('Réservation non trouvée');
    }

    if (!in_array($status, ['pending', 'confirmed', 'rejected'])) {
        $this->addFlash('error', 'État non valide.');
        return $this->redirectToRoute('app_admin');
    }

    // Mettre à jour l'état de la réservation
    $reservation->setStatus($status);
    $entityManager->flush();

    $this->addFlash('success', 'État de la réservation mis à jour avec succès.');

    return $this->redirectToRoute('app_admin');
}
}

