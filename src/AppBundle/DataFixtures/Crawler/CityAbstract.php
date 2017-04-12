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
        $html = file_get_contents($this->url . $suffix);
        dump('get data from: ' . $this->url . $suffix);
        return new Crawler($html);
    }

    abstract protected function getCityDataFromPage(Crawler $crawler, string $suffix): array;
}