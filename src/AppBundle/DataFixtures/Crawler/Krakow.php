<?php

namespace AppBundle\DataFixtures\Crawler;

use AppBundle\DataFixtures\Contract\CityInterface;
use Symfony\Component\DomCrawler\Crawler;

class Krakow extends CityAbstract implements CityInterface
{
    const ID = 2;
    const NAME = 'Kraków';
    protected $url = 'http://www.bip.krakow.pl/';
    protected $urlSuffix = '?bip_id=1&mmi=10501';

    public function execute(): array
    {
        $mainCrawler =  $this->getCrawlerForAddress($this->urlSuffix);

        $mapAddress = explode('?', $mainCrawler->filter('iframe')->attr('src'))[0];
        $mapAddressParts = explode('/', $mapAddress);
        $this->url = $mapAddress;

        $html = file_get_contents($mapAddress);
        $crawler =  new Crawler($html);

        $formCrawler = $crawler->filter('.tabela_ogloszenia_srodek form');

        $locationsIds = $formCrawler->filter('select option')->each(function ($node)  {
            return $node->attr('value');
        });

        $this->url = str_replace($mapAddressParts[count($mapAddressParts) - 1], $formCrawler->attr('action'), $mapAddress);
        $this->urlSuffix = '?id=%d';

        $locationsDataset = array_map(function($id) {
            $suffix = sprintf($this->urlSuffix, $id);
            $crawler = $this->getCrawlerForAddress($suffix);

            return $this->getCityDataFromPage($crawler, $suffix);
        }, $locationsIds);

        return $locationsDataset;
    }

    protected function getCityDataFromPage(Crawler $crawler, string $suffix): array {
        $locationDescription = $crawler->filter('.tabela_ogloszenia_srodek');
        $table = $locationDescription->filter('table table');

        $areaMatch = $populationMatch = $populationDensityMatch = '';
        $nameMatch = trim($locationDescription->filter('h3')->text());
        mb_ereg('\d+\.\d+', strtr($table->filter('tr')->eq(0)->filter('td')->eq(1)->filter('span')->text(), [',' => '.']), $areaMatch); //ha
        mb_ereg('\d+', $table->filter('tr')->eq(1)->filter('td')->eq(1)->text(), $populationMatch);

        $areaMatchInKm2 = round($areaMatch[0] / 100, 2);
        $populationDensityMatch = round($populationMatch[0] / $areaMatchInKm2, 2);

        return [
            'name' => $nameMatch,
            'area' => $areaMatchInKm2,
            'population' => $populationMatch[0],
            'PopulationDensity' => $populationDensityMatch,
            'url' => $this->url . $suffix,
            'city' => static::ID,
        ];
    }
}