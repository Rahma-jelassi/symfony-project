<?php

namespace App\Tests\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RoomControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/room/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Room::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Room index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'room[name]' => 'Testing',
            'room[description]' => 'Testing',
            'room[price]' => 'Testing',
            'room[size]' => 'Testing',
            'room[bedType]' => 'Testing',
            'room[maxOccupancy]' => 'Testing',
            'room[features]' => 'Testing',
            'room[bathroomFeatures]' => 'Testing',
            'room[furnishings]' => 'Testing',
            'room[services]' => 'Testing',
            'room[internet]' => 'Testing',
            'room[phone]' => 'Testing',
            'room[imageFilename]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Room();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setSize('My Title');
        $fixture->setBedType('My Title');
        $fixture->setMaxOccupancy('My Title');
        $fixture->setFeatures('My Title');
        $fixture->setBathroomFeatures('My Title');
        $fixture->setFurnishings('My Title');
        $fixture->setServices('My Title');
        $fixture->setInternet('My Title');
        $fixture->setPhone('My Title');
        $fixture->setImageFilename('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Room');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Room();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setPrice('Value');
        $fixture->setSize('Value');
        $fixture->setBedType('Value');
        $fixture->setMaxOccupancy('Value');
        $fixture->setFeatures('Value');
        $fixture->setBathroomFeatures('Value');
        $fixture->setFurnishings('Value');
        $fixture->setServices('Value');
        $fixture->setInternet('Value');
        $fixture->setPhone('Value');
        $fixture->setImageFilename('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'room[name]' => 'Something New',
            'room[description]' => 'Something New',
            'room[price]' => 'Something New',
            'room[size]' => 'Something New',
            'room[bedType]' => 'Something New',
            'room[maxOccupancy]' => 'Something New',
            'room[features]' => 'Something New',
            'room[bathroomFeatures]' => 'Something New',
            'room[furnishings]' => 'Something New',
            'room[services]' => 'Something New',
            'room[internet]' => 'Something New',
            'room[phone]' => 'Something New',
            'room[imageFilename]' => 'Something New',
        ]);

        self::assertResponseRedirects('/room/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getSize());
        self::assertSame('Something New', $fixture[0]->getBedType());
        self::assertSame('Something New', $fixture[0]->getMaxOccupancy());
        self::assertSame('Something New', $fixture[0]->getFeatures());
        self::assertSame('Something New', $fixture[0]->getBathroomFeatures());
        self::assertSame('Something New', $fixture[0]->getFurnishings());
        self::assertSame('Something New', $fixture[0]->getServices());
        self::assertSame('Something New', $fixture[0]->getInternet());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getImageFilename());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Room();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setPrice('Value');
        $fixture->setSize('Value');
        $fixture->setBedType('Value');
        $fixture->setMaxOccupancy('Value');
        $fixture->setFeatures('Value');
        $fixture->setBathroomFeatures('Value');
        $fixture->setFurnishings('Value');
        $fixture->setServices('Value');
        $fixture->setInternet('Value');
        $fixture->setPhone('Value');
        $fixture->setImageFilename('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/room/');
        self::assertSame(0, $this->repository->count([]));
    }
}
