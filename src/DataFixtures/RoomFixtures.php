<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoomFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'exemples de chambres avec des données factices
        $roomsData = [
            [
                'name' => 'Chambre Standard',
                'description' => 'Une chambre confortable pour un séjour agréable.',
                'price' => 100.00,
                'size' => '20 m²',
                'bedType' => 'Lit double',
                'maxOccupancy' => 2,
                'features' => 'Climatisation, TV écran plat, Mini-bar',
                'bathroomFeatures' => 'Douche, Sèche-cheveux',
                'furnishings' => 'Meubles modernes, Bureau',
                'services' => 'Service de chambre, Wi-Fi gratuit',
                'internet' => 'Wi-Fi',
                'phone' => 'Téléphone',
                'imageFilename' => 'room1.jpg',
            ],
            [
                'name' => 'Chambre Supérieure',
                'description' => 'Chambre spacieuse avec vue sur la mer.',
                'price' => 150.00,
                'size' => '30 m²',
                'bedType' => 'Lit king-size',
                'maxOccupancy' => 2,
                'features' => 'Climatisation, Télévision par satellite, Machine à café',
                'bathroomFeatures' => 'Baignoire, Peignoirs',
                'furnishings' => 'Salon, Table à manger',
                'services' => 'Service 24h/24, Wi-Fi gratuit',
                'internet' => 'Wi-Fi',
                'phone' => 'Téléphone',
                'imageFilename' => 'room2.jpg',
            ],
            [
                'name' => 'Suite Luxe',
                'description' => 'Suite de luxe avec vue imprenable et services premium.',
                'price' => 300.00,
                'size' => '50 m²',
                'bedType' => 'Lit super king-size',
                'maxOccupancy' => 4,
                'features' => 'Jacuzzi, Terrasse privée, Télévision grand écran',
                'bathroomFeatures' => 'Baignoire jacuzzi, Douche à l\'italienne',
                'furnishings' => 'Salon de luxe, Balcon',
                'services' => 'Concierge, Service de chauffeur',
                'internet' => 'Wi-Fi haut débit',
                'phone' => 'Téléphone',
                'imageFilename' => 'room3.jpg',
            ],
            [
                'name' => 'Suite Luxe',
                'description' => 'Suite de luxe avec vue imprenable et services premium.',
                'price' => 300.00,
                'size' => '50 m²',
                'bedType' => 'Lit super king-size',
                'maxOccupancy' => 4,
                'features' => 'Jacuzzi, Terrasse privée, Télévision grand écran',
                'bathroomFeatures' => 'Baignoire jacuzzi, Douche à l\'italienne',
                'furnishings' => 'Salon de luxe, Balcon',
                'services' => 'Concierge, Service de chauffeur',
                'internet' => 'Wi-Fi haut débit',
                'phone' => 'Téléphone',
                'imageFilename' => 'room4.jpg',
            ],
            [
                'name' => 'Suite Luxe',
                'description' => 'Suite de luxe avec vue imprenable et services premium.',
                'price' => 500.00,
                'size' => '50 m²',
                'bedType' => 'Lit super king-size',
                'maxOccupancy' => 4,
                'features' => 'Jacuzzi, Terrasse privée, Télévision grand écran',
                'bathroomFeatures' => 'Baignoire jacuzzi, Douche à l\'italienne',
                'furnishings' => 'Salon de luxe, Balcon',
                'services' => 'Concierge, Service de chauffeur',
                'internet' => 'Wi-Fi haut débit',
                'phone' => 'Téléphone',
                'imageFilename' => 'room5.jpeg',
            ],
            // Ajoutez d'autres chambres ici selon vos besoins
            // Ajoutez d'autres chambres ici selon vos besoins
        ];

        // Création et persistance des chambres
        foreach ($roomsData as $roomData) {
            $room = new Room();
            $room->setName($roomData['name'])
                ->setDescription($roomData['description'])
                ->setPrice($roomData['price'])
                ->setSize($roomData['size'])
                ->setBedType($roomData['bedType'])
                ->setMaxOccupancy($roomData['maxOccupancy'])
                ->setFeatures($roomData['features'])
                ->setBathroomFeatures($roomData['bathroomFeatures'])
                ->setFurnishings($roomData['furnishings'])
                ->setServices($roomData['services'])
                ->setInternet($roomData['internet'])
                ->setPhone($roomData['phone'])
                ->setImageFilename($roomData['imageFilename']);

            $manager->persist($room);
        }

        $manager->flush();
    }
}
