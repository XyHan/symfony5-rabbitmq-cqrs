<?php

namespace App\Ui\Controller;

use App\Application\Command\MyCommand\MyCommand;
use App\Application\Query\MyQuery\MyQuery;
use App\Domain\Command\CommandBus;
use App\Domain\Query\QueryBus;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class IndexController
 */
class IndexController extends AbstractController
{
    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     * @param SerializerInterface $serializer
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $command = new MyCommand(
            $request->request->get('requestId'),
            Uuid::uuid4(),
            $request->request->get('uuid')
        );
        $this->commandBus->dispatch($command);
        return new Response($this->serializer->serialize($command, 'json'));
    }

    /**
     * @Route("/listall", name="listall", methods={"GET"})
     */
    public function listAll(): Response
    {
        $query = new MyQuery();
        $entities = $this->queryBus->handleQuery($query);
        return new Response($this->serializer->serialize($entities, 'json'));
    }
}
