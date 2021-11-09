<?php

namespace App\Controller;

use App\Repository\Aggregate\MovieSessionRepository;
use App\Service\MovieSessionService;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Messenger\MessageBusInterface;

class BookingController extends AbstractController
{
    private MovieSessionRepository $movieSessionRepository;
    private MovieSessionService $movieSessionService;
    private MessageBusInterface $bus;

    public function __construct(MovieSessionRepository $movieSessionRepository, MovieSessionService $movieSessionService, MessageBusInterface $bus)
    {
        $this->movieSessionRepository = $movieSessionRepository;
        $this->movieSessionService = $movieSessionService;
        $this->bus = $bus;
    }

    public function create(Request $request): Response
    {
        $movieSession = $this->movieSessionRepository->find($request->query->get("movieSessionId"));

        $ticket = new Ticket(
            Uuid::uuid4(),
            $request->query->get("name"),
            $request->query->get("phone"),
            $movieSession
        );

        $this->bus->dispatch($ticket);

        return $this->index();
    }

    public function index(): Response
    {
        $forRender['title'] = 'Сеансы в кино';
        $forRender['movieSession'] = $this->movieSessionRepository->findAll();
        return $this->render('index.html.twig', $forRender);
    }
}