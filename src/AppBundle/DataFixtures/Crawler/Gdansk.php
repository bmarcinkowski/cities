<?php
namespace AppBundle\DataFixtures\Crawler;

use AppBundle\DataFixtures\Contract\CityInterface;
use Symfony\Component\DomCrawler\Crawler;

class Gdansk extends CityAbstract implements CityInterface
{
    const ID = 1;
    const NAME = 'Gdańsk';
    protected $url = 'http://gdansk.pl/';
    protected $urlSuffix = 'matarnia';

    public function execute(): array
    {
        $crawler = $this->getCrawlerForAddress($this->urlSuffix);

        $locationsDataset = $crawler->filter('.lista-dzielnic .dropdown-menu li a')->each(function ($node, $i) use ($crawler) {
            $suffix = $node->attr('href');

            if ('matarnia' === $node->attr('href') ) {
                return;
            }

            $crawler = $this->getCrawlerForAddress($suffix);

            return $this->getCityDataFromPage($crawler, $suffix);
        });

        $locationsDataset[] = $this->getCityDataFromPage($crawler, $this->urlSuffix);

        return $locationsDataset;
    }

    protected function getCityDataFromPage(Crawler $crawler, string $suffix): array {
        $locationDescription = $crawler->filter('div.opis > div');

        $areaMatch = $populationMatch = $populationDensityMatch = '';

        $nameMatch = trim($locationDescription->first()->text());
        mb_ereg('\d+\.\d+', strtr($locationDescription->eq(1)->text(), [',' => '.']), $areaMatch);
        mb_ereg('\d+', $locationDescription->eq(2)->text(), $populationMatch);
        mb_ereg('\d+', $locationDescription->last()->text(), $populationDensityMatch);

        return [
            'name' => $nameMatch,
            'area' =>  $areaMatch[0],
            'population' => $populationMatch[0],
            'PopulationDensity' => $populationDensityMatch[0],
            'url' => $this->url . $suffix,
            'city' => static::ID,
        ];
    }

}
