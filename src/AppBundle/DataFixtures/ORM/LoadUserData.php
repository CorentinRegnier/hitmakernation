<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var array
     */
    private $firstNames = ['Elyass', 'Clément', 'Mathieu', 'Thibault', 'David', 'Cédric', 'Yasmina', 'Jean-noël'];

    /**
     * @var array
     */
    private $lastNames = ['Messi', 'Ronaldo', 'Ozil', 'Ibrahimovic', 'LLoris', 'Balotelli', 'Rooney', 'Pogba'];
    /**
     * @var array
     */
    private $phone = ['+33103068596', '+36258245672', '+33333556644', '+33645987562', '+33644669988'];

    /**
     * @var array
     */
    private $address = [
        [
            'address' => '1 sente bonnière',
            'zipCode' => '60440',
            'city'    => 'Nanteuil le haudouin',
            'country' => 'France',
        ],
        [
            'address' => '25 rue de charles de gaulle',
            'zipCode' => '59700',
            'city'    => 'Marcq en baroeul',
            'country' => 'France',
        ],
        [
            'address' => '35 avenue des aubépines',
            'zipCode' => '37510',
            'city'    => 'Ballan miré',
            'country' => 'France',
        ],
        [
            'address' => '12 rue de l\'eau',
            'zipCode' => '69540',
            'city'    => 'Ville-Perdu',
            'country' => 'France',
        ],
        [
            'address' => '54 Avenue des champs élysée',
            'zipCode' => '13200',
            'city'    => 'Marseille',
            'country' => 'France',
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $randomAddress = $this->address[rand(0, 4)];
        $date          = new \DateTime();
        $superAdmin    = new User();
        $superAdmin
            ->setCivility(array_rand(array_flip(User::getAvailableCivilities())))
            ->setFirstName($this->firstNames[rand(0, 7)])
            ->setLastName($this->lastNames[rand(0, 7)])
            ->setPhone(array_rand(array_flip($this->phone)))
            ->setBirthdayDate($date->sub(new \DateInterval('P'.rand(18, 70).'Y')))
            ->setGeneralCondition(true)
            ->setAddress($randomAddress['address'])
            ->setCity($randomAddress['city'])
            ->setZipCode($randomAddress['zipCode'])
            ->setCountry($randomAddress['country'])
            ->setPlainPassword('xxx')
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->addRole('ROLE_SUPER_ADMIN')
            ->setEnabled(true);

        $manager->persist($superAdmin);
        $this->addReference('super-admin', $superAdmin);

        for ($i = 11; $i <= 20; $i++) {
            $randomAddress = $this->address[rand(0, 4)];
            $date          = new \DateTime();
            $user          = new User();
            $user
                ->setCivility(array_rand(array_flip(User::getAvailableCivilities())))
                ->setFirstName($this->firstNames[rand(0, 7)])
                ->setLastName($this->lastNames[rand(0, 7)])
                ->setPhone(array_rand(array_flip($this->phone)))
                ->setBirthdayDate($date->sub(new \DateInterval('P'.rand(18, 70).'Y')))
                ->setGeneralCondition(true)
                ->setAddress($randomAddress['address'])
                ->setCity($randomAddress['city'])
                ->setZipCode($randomAddress['zipCode'])
                ->setCountry($randomAddress['country'])
                ->setPlainPassword('xxx')
                ->setUsername('user'.$i)
                ->setEmail('user'.$i.'@gmail.com')
                ->addRole('ROLE_ADMIN')
                ->setEnabled(true);
            $manager->persist($user);
            $this->setReference('user-'.$i, $user);
        }

        for ($i = 1; $i <= 10; $i++) {
            $randomAddress = $this->address[rand(0, 4)];
            $date          = new \DateTime();
            $user          = new User();
            $user
                ->setCivility(array_rand(array_flip(User::getAvailableCivilities())))
                ->setFirstName($this->firstNames[rand(0, 7)])
                ->setLastName($this->lastNames[rand(0, 7)])
                ->setPhone(array_rand(array_flip($this->phone)))
                ->setBirthdayDate($date->sub(new \DateInterval('P'.rand(18, 70).'Y')))
                ->setGeneralCondition(true)
                ->setAddress($randomAddress['address'])
                ->setCity($randomAddress['city'])
                ->setZipCode($randomAddress['zipCode'])
                ->setCountry($randomAddress['country'])
                ->setPlainPassword('xxx')
                ->setUsername('user'.$i)
                ->setEmail('user'.$i.'@gmail.com')
                ->setEnabled(true);
            $manager->persist($user);
            $this->setReference('user-'.$i, $user);
        }
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
