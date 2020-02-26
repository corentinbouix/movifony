<?php

declare(strict_types=1);

namespace Movifony\Action;

use Doctrine\Persistence\ManagerRegistry;
use Movifony\Entity\ImdbMovie;
use Movifony\Form\MovieType;
use Movifony\Repository\MovieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Create a movie using Form components
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class AddMovieAction
{
    protected FormFactoryInterface $formFactory;

    protected ManagerRegistry $managerRegistry;

    protected RouterInterface $router;

    /**
     * @param FormFactoryInterface $formFactory
     * @param ManagerRegistry      $managerRegistry
     * @param RouterInterface      $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        ManagerRegistry $managerRegistry,
        RouterInterface $router
    ) {
        $this->formFactory = $formFactory;
        $this->managerRegistry = $managerRegistry;
        $this->router = $router;
    }

    /**
     * @Template("add_movie.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $newMovie = new ImdbMovie();
        $form = $this->formFactory->create(MovieType::class, $newMovie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->managerRegistry->getManagerForClass(ImdbMovie::class);
            $em->persist($newMovie);
            $em->flush();

            $routePath = $this->router->generate('mf_last_movies');

            return new RedirectResponse($routePath);
        }

        return [
            'addMovieForm' => $form->createView(),
        ];
    }
}
