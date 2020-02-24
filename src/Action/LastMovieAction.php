<?php

declare(strict_types=1);

namespace Movifony\Action;

use Movifony\Repository\MovieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Display last movies
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
     * @Template("last_movies.html.twig")
     *
     * @param $limit
     *
     * @return array
     */
    public function __invoke(int $limit): array
    {
        $movies = $this->movieRepository->findLatestMovies($limit);

        if (empty($movies)) {
            throw new NotFoundHttpException("Can't find any movie");
        }

        return [
            'movies' => $movies,
        ];
    }
}
