<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\InvalidEntityException;
use App\Manager\CustomManager;
use App\Model\AddModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/v1")
 */
class CustomController extends AbstractController
{
    /**
     * Add result.
     *
     * @OA\RequestBody(@Model(type=AddModel::class))
     * @OA\Parameter(name="parameter", in="query", required=true, @OA\Schema(enum={"type1", "type2"}))
     * @OA\Response(
     *     response=204,
     *     description="Successful",
     *     @OA\JsonContent(
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Wrong data"
     * )
     * @OA\Response(
     *     response=403,
     *     description="Unauthorized"
     * )
     * @OA\Tag(name="Add")
     *
     * @Route("/add", methods={"POST"}, requirements={"gameSessionId"="\d+"})
     *
     * @return JsonResponse
     * @throws InvalidEntityException
     */
    public function addAction(
        CustomManager $customManager,
        SerializerInterface $serializer,
        Request $request
    ): Response {
        /** @var AddModel $model */
        $model = $serializer->deserialize($request->getContent(), AddModel::class, 'json');
        $customManager->addModel($request->get('parameter'), $model);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
