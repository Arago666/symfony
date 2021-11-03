<?php

namespace App\Controller;

use App\Form\MovieSessionType;
use App\Repository\Aggregate\MovieSessionRepository;
use App\Service\MovieSessionService;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends AbstractController
{
    private MovieSessionRepository $movieSessionRepository;
    private MovieSessionService  $movieSessionService;

    public function __construct(MovieSessionRepository $movieSessionRepository, MovieSessionService $movieSessionService)
    {
        $this->movieSessionRepository = $movieSessionRepository;
        $this->movieSessionService = $movieSessionService;
    }

    public function create(Request $request): Response
    {
        $client = new Client(
            Uuid::uuid4(),
            $request->query->get("name"),
            $request->query->get("phone")
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

        $movieSession = $this->movieSessionRepository->find($request->query->get("movieSessionId"));
        $movieSession->addTickets($client);
        $movieSession->reduceFreeTicket();

        return $this->index();
    }

    public function index(): Response
    {
        $forRender['title'] = 'Сеансы в кино';
        $forRender['movieSession'] = $this->movieSessionRepository->findAll();
        return $this->render('index.html.twig', $forRender);
    }
}