<?php

namespace App\Controller;

use App\Command\AddTicketCommand;
use App\Repository\Aggregate\MovieSessionRepository;
use App\Service\MovieSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;

class IndexController extends AbstractController
{
    private MovieSessionRepository $movieSessionRepository;
    private MovieSessionService  $movieSessionService;

    public function __construct(MovieSessionRepository $movieSessionRepository, MovieSessionService $movieSessionService)
    {
        $this->movieSessionRepository = $movieSessionRepository;
        $this->movieSessionService = $movieSessionService;
    }

    public function indexAction()
    {
        $forRender['title'] = 'Сеансы в кино';
        $forRender['movieSession'] = $this->movieSessionRepository->getMovieSession();
        return $this->render('index.html.twig', $forRender);
    }

    public function addTicketAction(Request $request): void
    {
        $data = $request->request->all();
        $command = new AddTicketCommand();
        $command->id = Uuid::uuid4();;
        $command->name = $data['name'];
        $command->phone = $data['phone'];
        $this->container->get('command_bus')->handle($command);
        $this->movieSessionService->getOne($data['id'])->addTickets($command);
    }
}