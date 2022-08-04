<?php

namespace OpenFoodFacts\Laravel\Tests;

use Illuminate\Support\Facades\Config;
use OpenFoodFacts\Laravel\Facades\OpenFoodFacts as OpenFoodFactsFacade;
use OpenFoodFacts\Laravel\OpenFoodFacts;

class GeographyTest extends Base\FacadeTestCase
{
    /** @test */
    public function it_returns_different_content_based_on_geography_parameter()
    {
        $instanceWorld = app()->make(OpenFoodFacts::class);
        $product_default_content = $instanceWorld->barcode('8714200216964');

        $instanceNL = app()->make(OpenFoodFacts::class, ['geography' => 'nl']);
        $product_dutch_content = $instanceNL->barcode('8714200216964');

        $this->assertEquals($product_default_content['_id'], $product_dutch_content['_id']);
        $this->assertNotEquals($product_default_content, $product_dutch_content);
    }

    /** @test */
    public function it_returns_geo_specific_content_through_config_setting()
    {
        Config::set('openfoodfacts.geography', 'nl');
        $product_dutch_content = OpenFoodFactsFacade::barcode('8714200216964');

        $this->assertStringContainsString('front_nl.', $product_dutch_content['image_url']);
    }
}
