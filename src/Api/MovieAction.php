<?php

declare(strict_types=1);

namespace Movifony\Api;

use Movifony\Entity\ImdbMovie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MovieAction
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class MovieAction
{
    protected SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @ParamConverter(name="movie", class="Movifony\Entity\ImdbMovie")
     *
     * @param ImdbMovie $movie
     *
     * @return Response
     */
    public function __invoke(ImdbMovie $movie)
    {
        $movie = $this->serializer->serialize(
            $movie,
            JsonEncoder::FORMAT,
            [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['persons'],
            ]
        );

        return new JsonResponse($movie, 200, [], true);
    }
}
