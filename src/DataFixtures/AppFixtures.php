<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * Encoder of password
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($c = 0; $c < 30; $c++) {

            $chrono = 1;

            $user = new User();
            $hash = $this->encoder->encodePassword($user, "password");

            $user
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setPassword($hash)
            ;

            $manager->persist($user);

            $customer = new Customer();
            $customer
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setCompany($faker->company())
            ;

            $manager->persist($customer);

            for ($i = 0; $i < mt_rand(3, 10); $i++) {
                $invoice = new Invoice();
                $invoice
                    ->setAmount($faker->randomFloat(2, 250, 5000))
                    ->setSentAt($faker->dateTimeBetween('-6 months'))
                    ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                    ->setCustomer($customer)
                    ->setChrono($chrono)
                ;

                $chrono++;

                $manager->persist($invoice);
            }
        }


        $manager->flush();
    }
}
