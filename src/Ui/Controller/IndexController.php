<?php

namespace App\Ui\Controller;

use App\Application\Query\MyQuery\MyQuery;
use App\Application\Query\MyQuery\MyQueryHandler;
use App\Domain\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param QueryBus $queryBus
     * @param SerializerInterface $serializer
     */
    public function __construct(QueryBus $queryBus, SerializerInterface $serializer)
    {
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return new JsonResponse('Hello !');
    }

    /**
     * @Route("/listall", name="listall", methods={"GET"})
     */
    public function listAll(): JsonResponse
    {
        $query = new MyQuery();
        $entities = $this->queryBus->handleQuery($query);
        return new JsonResponse($this->serializer->serialize($entities, 'json'));
    }
}
