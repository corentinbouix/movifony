<?php

declare(strict_types=1);

namespace Movifony\Service;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ImdbAssetGetter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbAssetGetter implements AssetGetterInterface
{
    protected const IMDB_URL_ROOT = 'https://www.imdb.com';

    protected const IMDB_POSTER_PATH = '.main .poster img';

    /** @var HttpClientInterface */
    protected HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function getPoster(string $identifier): ?string
    {
        $pageContent = $this->getPageContent($identifier);

        return $this->getPosterUrl($pageContent);
    }

    /**
     * @param string $identifier
     *
     * @return string
     *
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function getPageContent(string $identifier): string
    {
        $content = $this->httpClient->request(
            Request::METHOD_GET,
            $this->getPageUrlFor([$identifier])
        );

        return $content->getContent();
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    protected function getPageUrlFor(array $parameters): string
    {
        $url = implode(
            DIRECTORY_SEPARATOR,
            array_merge(
                [
                    self::IMDB_URL_ROOT,
                    'title',
                ],
                $parameters
            )
        );

        // Add a trailing slash at the end to avoid 301 redirect from IMDB
        return $url.DIRECTORY_SEPARATOR;
    }

    /**
     * Return the URL of the asset
     *
     * @param string $content
     *
     * @return string|null
     */
    protected function getPosterUrl(string $content): ?string
    {
        $crawler = new Crawler($content);

        $posterUrlNode = $crawler->filter(self::IMDB_POSTER_PATH);

        if ($posterUrlNode->count() !== 0) {
            return $posterUrlNode->attr('src');
        }

        return null;
    }
}
