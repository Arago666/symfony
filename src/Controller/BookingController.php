<?php

namespace App\Controller;

use App\Message\AddTicketCommand;
use App\Repository\Aggregate\MovieSessionRepository;
use App\Service\MovieSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
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

        $command = new AddTicketCommand(
            Uuid::v4(),
            (string)$request->query->get("name"),
            (string)$request->query->get("phone"),
            $movieSession
        );

        $this->bus->dispatch($command);

        return $this->redirectToRoute('booking');
    }

    public function index(): Response
    {
        $forRender['title'] = 'Сеансы в кино';
        $forRender['movieSession'] = $this->movieSessionRepository->findAll();
        return $this->render('index.html.twig', $forRender);
    }
}