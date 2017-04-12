<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\Crawler\Gdansk;
use AppBundle\DataFixtures\Crawler\Krakow;
use AppBundle\Entity\District;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $CitiesDistricts =
            (new Krakow())->execute()
            + (new Gdansk())->execute();

        foreach($CitiesDistricts as $district) {
            $districtObject = (new District())
                ->setArea($district['area'])
                ->setCity($district['city'])
                ->setName($district['name'])
                ->setPopulation($district['population'])
                ->setPopulationDensity($district['PopulationDensity'])
                ->setUrl($district['url']);
            $manager->persist($districtObject);
        }
        $manager->flush();
    }

}