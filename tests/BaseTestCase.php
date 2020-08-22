<?php
declare(strict_types=1);

namespace tests;

use App\Entity\Post;
use App\Service\Post\PostsFetcher;
use Config\Di\ServiceContainer;
use Config\DiConfig;
use PHPUnit\Framework\TestCase;

/**
 * Currently there are no tests in this base class, that's why it doesn't end with Test
 * Renaming it to end with Test will cause PHPUnit to run tests in this file and will issue warning
 */
class BaseTestCase extends TestCase
{
    protected ServiceContainer $container;
    private PostsFetcher $postsFetcher;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = (new DiConfig())->setupConfig();
        $this->postsFetcher = $this->container->getService('postsFetcher');
    }

    /**
     * @return Post[]
     */
    protected function getSampleFetchedPosts(): array
    {
        return $this->postsFetcher->mapToEntities(
            $this->getSamplePosts()
        );
    }

    private function getSamplePosts(): array
    {
        return [
            // Feb - 8th & 7th week posts by user1 & user2
            [
                'id' => 'post1',
                'message' => 'test message 1', // length: 14
                'from_id' => 'user1',
                'from_name' => 'test user1',
                'type' => 'status',
                'created_time' => '2019-02-19T12:01:37+00:00',
            ],
            [
                'id' => 'post2',
                'message' => 'test message 12', // length: 15
                'from_id' => 'user1',
                'from_name' => 'test user1',
                'type' => 'status',
                'created_time' => '2019-02-20T12:01:37+00:00'
            ],
            [
                'id' => 'post3',
                'message' => 'test message 123', // length: 16
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-02-12T12:01:37+00:00'
            ],
            [
                'id' => 'post4',
                'message' => 'test message 1234', // length: 17
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-02-13T12:01:37+00:00'
            ],
            [
                'id' => 'post5',
                'message' => 'test message 12345', // length: 18
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-02-14T12:01:37+00:00'
            ],
            [
                'id' => 'post6',
                'message' => 'test message 123456', // length: 19
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-02-15T12:01:37+00:00'
            ]
            // averageCharacterLengthPerPostPerMonth = 14 + 15 + 16 + 17 + 18 + 19 / 6 = 16.5
            ,
            // Jan - Ist & 3rd week posts by user1 & user2
            [
                'id' => 'post7',
                'message' => 'test message 1234567', // length: 20
                'from_id' => 'user1',
                'from_name' => 'test user1',
                'type' => 'status',
                'created_time' => '2019-01-02T12:01:37+00:00'
            ],
            [
                'id' => 'post8',
                'message' => 'test message 12345678', // length: 21
                'from_id' => 'user1',
                'from_name' => 'test user1',
                'type' => 'status',
                'created_time' => '2019-01-03T12:01:37+00:00'
            ],
            [
                'id' => 'post9',
                'message' => 'test message 123456789', // length: 22
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-01-15T12:01:37+00:00'
            ],
            [
                'id' => 'post10',
                'message' => 'test message 12345678910', // length: 24
                'from_id' => 'user2',
                'from_name' => 'test user2',
                'type' => 'status',
                'created_time' => '2019-01-16T12:01:37+00:00'
            ],
            [
                'id' => 'post11',
                'message' => 'test message 12345678910 1', // length: 26
                'from_id' => 'user1',
                'from_name' => 'test user1',
                'type' => 'status',
                'created_time' => '2019-01-01T12:01:37+00:00'
            ]
            // averageCharacterLengthPerPostPerMonth = 20 + 21 + 22 + 24 + 26 / 5 = 22.6
        ];
    }
}
