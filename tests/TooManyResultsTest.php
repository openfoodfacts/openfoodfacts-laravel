<?php

namespace OpenFoodFacts\Laravel\Tests;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Config;
use OpenFoodFacts\Api;
use OpenFoodFacts\Collection;
use OpenFoodFacts\Laravel\Exceptions\TooManyResultsException;
use OpenFoodFacts\Laravel\OpenFoodFacts;
use PHPUnit\Framework\Attributes\Test;

final class TooManyResultsTest extends Base\FacadeTestCase
{
    #[Test]
    public function it_exposes_total_matches_and_max_results(): void
    {
        $exception = new TooManyResultsException(2000, 1000);

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame(2000, $exception->totalMatches);
        $this->assertSame(1000, $exception->maxResults);
        $this->assertSame(
            'ERROR: 2000 results found, while buffer limited to 1000. Please narrow your search.',
            $exception->getMessage()
        );
    }

    #[Test]
    public function find_throws_when_matches_exceed_max_results(): void
    {
        Config::set('openfoodfacts.max_results', 1000);

        $api = $this->createMock(Api::class);
        $api->expects($this->once())
            ->method('search')
            ->with('cola', 1, 100)
            ->willReturn($this->page(2000, 1));

        try {
            $this->makeInstance($api)->find('cola');
            $this->fail('TooManyResultsException was not thrown');
        } catch (TooManyResultsException $e) {
            $this->assertSame(2000, $e->totalMatches);
            $this->assertSame(1000, $e->maxResults);
        }
    }

    #[Test]
    public function find_does_not_throw_when_matches_equal_max_results(): void
    {
        Config::set('openfoodfacts.max_results', 2);

        $api = $this->createStub(Api::class);
        $api->method('search')->willReturn($this->page(2, 1));

        $this->assertCount(2, $this->makeInstance($api)->find('cola'));
    }

    #[Test]
    public function find_does_not_limit_results_when_max_results_is_zero(): void
    {
        Config::set('openfoodfacts.max_results', 0);

        $api = $this->createMock(Api::class);
        $api->expects($this->exactly(2))
            ->method('search')
            ->willReturnCallback(fn (string $term, int $page) => $this->page(150, $page));

        $this->assertCount(150, $this->makeInstance($api)->find('cola'));
    }

    private function page(int $count, int $page): Collection
    {
        $pageSize = 100;
        $items = min($pageSize, $count - ($page - 1) * $pageSize);

        return new Collection([
            'products' => array_map(
                fn (int $i) => ['code' => (string)(($page - 1) * $pageSize + $i)],
                range(1, $items)
            ),
            'count' => $count,
            'page' => $page,
            'skip' => ($page - 1) * $pageSize,
            'page_size' => $pageSize,
        ]);
    }

    private function makeInstance(Api $api): OpenFoodFacts
    {
        return new class (app(), $api) extends OpenFoodFacts {
            public function __construct(Container $app, private readonly Api $fakeApi)
            {
                parent::__construct($app);
            }

            protected function setupApi(string $environment): Api
            {
                return $this->fakeApi;
            }
        };
    }
}
