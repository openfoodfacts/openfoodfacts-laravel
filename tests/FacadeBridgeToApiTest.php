<?php

namespace OpenFoodFacts\Laravel\Tests;

use OpenFoodFacts\Document;
use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;
use PHPUnit\Framework\Attributes\Test;

final class FacadeBridgeToApiTest extends Base\FacadeTestCase
{
    #[Test]
    public function it_calls_method_on_vendor_apiclass(): void
    {
        $doc = OpenFoodFacts::getProduct('0737628064502');

        $this->assertInstanceOf(Document::class, $doc);
    }
}
