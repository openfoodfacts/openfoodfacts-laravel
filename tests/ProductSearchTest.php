<?php

namespace OpenFoodFacts\Laravel\Tests;

use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;
use PHPUnit\Framework\Attributes\Test;

final class ProductSearchTest extends Base\FacadeTestCase
{
    #[Test]
    public function it_returns_a_laravelcollection_with_arrays(): void
    {
        $results = OpenFoodFacts::find('Stir-Fry Rice Noodles');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $this->assertTrue($results->isNotEmpty());

        $results->each(function ($arr) {
            $this->assertIsArray($arr);
        });
    }

    #[Test]
    public function it_returns_an_empty_laravelcollection_when_no_results_found(): void
    {
        $results = OpenFoodFacts::find('no-such-product-exists');

        $this->assertEquals(true, $results->isEmpty());
    }

    #[Test]
    public function it_throws_an_exception_on_too_many_results(): void
    {
        $this->expectException('Exception');

        OpenFoodFacts::find('cola');
    }

    #[Test]
    public function it_throws_an_exception_when_argument_empty(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Specify a search term to find data for matching products');

        OpenFoodFacts::find('');
    }
}
