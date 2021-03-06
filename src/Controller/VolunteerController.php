<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Form\Registration\VolunteerType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\VolunteerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/volunteer")
 */
final class VolunteerController extends AbstractController
{
    private $eventService;
    private $volunteerService;

    public function __construct(EventService $event, VolunteerService $volunteer)
    {
        $this->eventService = $event;
        $this->volunteerService = $volunteer;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function homeAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('volunteer/home.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/register", methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function registerAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();
        if (!$event->isEnabledVolunteerRegistration()) {
            return $this->redirectToRoute('balticrobo_website_default_home');
        }

        $form = $this->createForm(VolunteerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->volunteerService->add($form->getData(), $event, new \DateTimeImmutable());

            return $this->render('volunteer/register_success.html.twig', [
                'event' => $event,
            ]);
        }

        return $this->render('volunteer/register_form.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }
}
