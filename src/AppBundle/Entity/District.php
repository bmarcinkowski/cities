<?php

namespace AppBundle\Entity;

use AppBundle\DataFixtures\Crawler\Gdansk;
use AppBundle\DataFixtures\Crawler\Krakow;
use Doctrine\ORM\Mapping as ORM;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistrictRepository")
 */
class District
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="area_km2", type="decimal", precision=6, scale=2)
     */
    protected $area;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="integer")
     */
    protected $population;

    /**
     * @var int
     *
     * @ORM\Column(name="populationDensity", type="integer")
     */
    protected $populationDensity;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100, unique=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="integer")
     */
    protected $city;

    protected $cityDictionary = [
        Gdansk::ID => Gdansk::NAME,
        Krakow::ID => Krakow::NAME,
    ];


    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function setId($id): District
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return District
     */
    public function setName(string $name): District
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set area
     *
     * @param string $area
     *
     * @return District
     */
    public function setArea(float $area): District
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea(): float
    {
        return $this->area;
    }

    /**
     * Set population
     *
     * @param int $population
     *
     * @return District
     */
    public function setPopulation(int $population): District
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return int
     */
    public function getPopulation(): int
    {
        return $this->population;
    }

    /**
     * Set populationDensity
     *
     * @param integer $populationDensity
     *
     * @return District
     */
    public function setPopulationDensity(int $populationDensity): District
    {
        $this->populationDensity = $populationDensity;

        return $this;
    }

    /**
     * Get populationDensity
     *
     * @return int
     */
    public function getPopulationDensity(): int
    {
        return $this->populationDensity;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return District
     */
    public function setUrl(string $url): District
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * set City
     *
     * @param string $city
     *
     * @return District
     */
    public function setCity(string $city): District
    {
        $this->city = $city;

        return $this;
    }

    /**
     * get City
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * get City
     *
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityDictionary[$this->city];
    }

}

