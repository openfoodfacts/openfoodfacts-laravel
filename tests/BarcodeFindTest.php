<?php

namespace OpenFoodFacts\Laravel\Tests;

use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;

class BarcodeFindTest extends Base\FacadeTestCase
{
    /** @test */
    public function it_returns_an_array_with_data_when_product_found()
    {
        $arr = OpenFoodFacts::barcode('0737628064502');

        $this->assertArrayHasKey('code', $arr);
    }

    /** @test */
    public function it_returns_an_empty_array_when_product_not_found()
    {
        $arr = OpenFoodFacts::barcode('this-barcode-does-not-exist');

        $this->assertEquals([], $arr);
    }

    /** @test */
    public function it_throws_an_exception_when_argument_empty()
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Argument must represent a barcode");

        OpenFoodFacts::barcode('');
    }
}
