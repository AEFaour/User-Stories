<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $numberOfCategory = 10;
        $numberOfUsers = 5;

        for($i=1; $i <= 200; $i++){
            $advert = new Advert();
            $advert ->setTitle($faker->sentence(8))
                ->setText($faker->text(mt_rand(300, 1500)))
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setPhoto($faker->image('public/uploads/photos',400,600, null, false))
                ->setCategory($this->getReference("category_".mt_rand(1, $numberOfCategory)))
                ->setAdvertUser($this->getReference("advert_user_". mt_rand(1, $numberOfUsers)));
            $this->addReference("ad_$i", $advert);
            $manager->persist($advert);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}
