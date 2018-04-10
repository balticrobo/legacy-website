<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function homeAction(Request $request): Response
    {
        $rules = $this->eventService->getCurrentRulesByLocale($request->getLocale());

        return $this->render('default/home.html.twig', [
            'rules' => $rules,
        ]);
    }
}
