<?php

declare(strict_types=1);

namespace Movifony\Api;

use Movifony\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LastMovieAction
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class LastMovieAction
{
    protected MovieRepository $movieRepository;

    /**
     * @param MovieRepository $movieRepository
     */
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @param int $limit
     *
     * @return JsonResponse
     */
    public function __invoke(int $limit): JsonResponse
    {
        $movies = $this->movieRepository->findLatestMovies($limit);

        return new JsonResponse($movies);
    }
}
