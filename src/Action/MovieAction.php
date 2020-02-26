<?php

declare(strict_types=1);

namespace Movifony\Action;

use Movifony\Entity\ImdbMovie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Display one movie page
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class MovieAction
{
    /**
     * @Template("movie.html.twig")
     *
     * @ParamConverter(name="movie", class="Movifony\Entity\ImdbMovie")
     *
     * @param ImdbMovie $movie
     *
     * @return array
     */
    public function __invoke(ImdbMovie $movie)
    {
        return [
            'movie' => $movie,
        ];
    }
}
