<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $amsterdam = new Conference();
        $amsterdam->setCity('Amsterdam');
        $amsterdam->setYear('2019');
        $amsterdam->setIsInternational(true);

        $manager->persist($amsterdam);

        $paris = new Conference();
        $paris->setCity('Paris');
        $paris->setYear('2020');
        $paris->setIsInternational(false);

        $manager->persist($paris);

        $comment = new Comment();
        $comment->setConference($amsterdam);
        $comment->setAuthor('Fabien');
        $comment->setEmail('fabien@example.com');
        $comment->setText('This was a great conference');
        $comment->setState('published');

        $manager->persist($comment);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@localhost.com');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));

        $manager->persist($admin);

        $manager->flush();
    }
}
