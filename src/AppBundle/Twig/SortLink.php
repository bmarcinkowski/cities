<?php
/**
 * Created by PhpStorm.
 * User: kud3aty
 * Date: 12.04.2017
 * Time: 21:30
 */

namespace AppBundle\Twig;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SortLink extends \Twig_Extension
{
    protected $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sortHeader', array($this, 'sortHeader')),
        );
    }

    public function sortHeader($name, $columnName, $searchCriteria, $orderCriteria)
    {
        $class = '';
        $direction = '1';

        if (!empty($orderCriteria) && $orderCriteria['column'] == $columnName) {
            $class = 'active-desc';
            if ($orderCriteria['direction'] == 'ASC') {
                $direction = '0';
                $class = 'active-asc';
            }
        }
        $url = $this->generator->generate('district_index', array_merge($searchCriteria, [$columnName => $direction]));
        $link = '<a href="' . $url . '"' . (!empty($class) ? 'class="' . $class . '">' : '>') . $name . '</a>';

        return $link;
    }
}