<?php

namespace AppBundle\Controller;

use AppBundle\Entity\District;
use AppBundle\Form\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * District controller.
 *
 * @Route("district")
 */
class DistrictController extends Controller
{

    protected $allowGETParameters = [
        'c' => 'city',
        'n' => 'name',
    ];
    protected $allowGETOrders = [
        'o_c' => 'city',
        'o_n' => 'name',
        'o_p' => 'population',
        'o_pd' => 'populationDensity',
        'o_a' => 'area',
    ];

    /**
     * Lists all district entities.
     *
     * @Route("/", name="district_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        list($searchCriteria, $dbCriteria) = $this->getSearchCriteriaFromUrl($requestParams = $request->query->all());
        $orderCriteria = $this->getSearchOrderFromUrl($requestParams = $request->query->all());
        $districtRepository = $em->getRepository('AppBundle:District');
        $hasDistrictInDatabase = true;

        $districts = $districtRepository->findBySearchCriteria(
            $dbCriteria,
            !$orderCriteria ? [] :
                [
                    $orderCriteria['db_column'] => $orderCriteria['direction']
                ]
        );

        if (empty($districts)) {
            $hasDistrictInDatabase = (bool)$districtRepository->findOneBy([]);
        }

        $form = $this->createForm(Search::class, $searchCriteria);

        return $this->render('district/index.html.twig', array(
            'districts' => $districts,
            'searchCriteria' => $searchCriteria,
            'orderCriteria' => $orderCriteria,
            'hasDistrictInDatabase' => $hasDistrictInDatabase,
            'searchNameForm' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a district entity.
     *
     * @Route("/{id}", name="district_show")
     * @Method("GET")
     */
    public function showAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository('AppBundle:District')->find($id);

        return $this->render('district/show.html.twig', array(
            'district' => $district,
        ));
    }

    /**
     * Finds and displays a district entity.
     *
     * @Route("/{id}", name="district_delete")
     * @Method("DELETE")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:District')->findOneBy(array('id' => $id));

        if ($entity != null) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash(
                'notice',
                'Dzielnica "' . $entity->getCityName() . ' - ' . $entity->getName() . '" prawidłowo usunięta!'
            );
        } else {
            $this->addFlash(
                'notice',
                'Dzielnica wybrana do usunięcia nie istnieje!'
            );
        }

        return $this->json(array('url' => $this->generateUrl('district_index')));
    }

    protected function getSearchCriteriaFromUrl($params)
    {
        if (empty($params)) {
            return [
                [],
                []
            ];
        }
        $allowGETParameters = $this->allowGETParameters;

        ksort($params);
        ksort($allowGETParameters);

        $params = array_intersect_key($params, $allowGETParameters);
        $allowParameters = array_intersect_key($allowGETParameters, $params);

        return [
            $params,
            array_combine($allowParameters, $params)
        ];
    }

    protected function getSearchOrderFromUrl($params)
    {
        if (empty($params)) {
            return [];
        }

        $allowGETOrders = $this->allowGETOrders;

        ksort($params);
        ksort($allowGETOrders);

        $params = array_intersect_key($params, $allowGETOrders);

        if (empty($params)) {
            return [];
        }

        $allowParameters = array_intersect_key($allowGETOrders, $params);

        $key = array_keys($params)[0];

        return [
            'column' => $key,
            'db_column' => $allowParameters[$key],
            'direction' => 1 == $params[$key] ? 'ASC' : 'DESC',
        ];
    }
}
