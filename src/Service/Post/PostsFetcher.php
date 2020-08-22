<?php
declare(strict_types=1);

namespace App\Service\Post;

use App\Entity\Post;
use App\Service\Token\TokenProvider;
use Doctrine\Common\Cache\CacheProvider;
use Psr\Log\LoggerInterface;
use Zend\Http\Client;
use Zend\Http\Request;

class PostsFetcher
{
    private const POSTS_CACHE_KEY = 'allPosts';
    private CacheProvider $cache;
    private array $params;
    private TokenProvider $tokenProvider;
    private Client $client;
    private PostsDenormalizer $postsDenormalizer;
    private LoggerInterface $logger;

    public function __construct(
        CacheProvider $cache,
        array $params,
        TokenProvider $tokenProvider,
        Client $client,
        PostsDenormalizer $postsDenormalizer,
        LoggerInterface $logger
    ) {
        $this->cache = $cache;
        $this->params = $params;
        $this->tokenProvider = $tokenProvider;
        $this->client = $client;
        $this->postsDenormalizer = $postsDenormalizer;
        $this->logger = $logger;
    }

    /**
     * @return Post[]
     */
    public function fetchAllPosts(): array
    {
        if (!$this->cache->contains(self::POSTS_CACHE_KEY)) {
            $slToken = $this->tokenProvider->provideToken();
            if ($slToken === null) {
                throw new \UnexpectedValueException('No registered token available!');
            }

            $allPosts = [];
            for ($i = $this->params['startPage']; $i <= $this->params['endPage']; $i++) {
                $postsByPage = $this->fetchPostsByPage($i, $slToken);
                foreach ($postsByPage as $postByPage) {
                    $allPosts[] = $postByPage;
                }
            }

            // cache fetched posts, so page loads faster on subsequent requests
            if (!$this->cache->save(self::POSTS_CACHE_KEY, $allPosts, 3600)) {
                throw new \UnexpectedValueException('Cache is not available!');
            }
        }

        return $this->cache->fetch(self::POSTS_CACHE_KEY);
    }

    /**
     * @return Post[]
     */
    private function fetchPostsByPage(int $page, string $slToken): array
    {
        $response = $this->client->send(
            (new Request())
                ->setMethod(Request::METHOD_GET)
                ->setUri($this->params['url'] . '?sl_token=' . $slToken . '&page=' . $page)
        );

        $decodedData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        if (isset($decodedData['error'])) {
            $this->logger->debug('Error while fetching posts', $decodedData['error']);
            if ($decodedData['error']['message'] === 'Invalid SL Token') {
                // try again with new token
                $this->fetchPostsByPage($page, $this->tokenProvider->registerToken());
            }
        }

        return $this->mapToEntities($decodedData['data']['posts']);
    }

    /**
     * @return Post[]
     */
    public function mapToEntities(array $posts): array
    {
        $returnPosts = [];
        foreach ($posts as $postData) {
            $returnPosts[] = $this->postsDenormalizer->denormalize($postData);
        }

        return $returnPosts;
    }
}
