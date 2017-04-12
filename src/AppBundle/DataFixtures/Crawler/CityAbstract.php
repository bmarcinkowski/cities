<?php

namespace AppBundle\DataFixtures\Crawler;

use Symfony\Component\DomCrawler\Crawler;

abstract class CityAbstract {

    protected $url;
    protected $urlSuffix;

    /**
     * @param $suffix
     * @return Crawler
     */
    protected function getCrawlerForAddress(string $suffix):Crawler
    {
        dump('próbuję pobrać dane z: ' . $this->url . $suffix);
        $html = file_get_contents($this->url . $suffix);
        dump('pobrane poprawnie');
        return new Crawler($html);
    }

    abstract protected function getCityDataFromPage(Crawler $crawler, string $suffix): array;
}