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
use Exception;

class BookingController extends AbstractController
{
    private MovieSessionRepository $movieSessionRepository;
    private MessageBusInterface $bus;

    public function __construct(MovieSessionRepository $movieSessionRepository, MessageBusInterface $bus)
    {
        $this->movieSessionRepository = $movieSessionRepository;
        $this->bus = $bus;
    }

    public function create(Request $request): Response
    {
        if (!$request->query->get("name") || !$request->query->get("phone")) {
            throw new Exception("Не заполнено поле имя или телефон");
        }

        $movieSession = $this->movieSessionRepository->find($request->query->get("movieSessionId"));

        if (!$movieSession) {
            throw new Exception("Несуществующий сеанс");
        }

        if ($movieSession->getQuantityTickets() <= 0) {
            throw new Exception("Отсутсвуют свободные билеты");
        }

        $command = new AddTicketCommand(
            Uuid::v4(),
            (string) $request->query->get("name"),
            (string) $request->query->get("phone"),
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