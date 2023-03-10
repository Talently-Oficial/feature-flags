<?php

namespace Tests\Drivers\GrowthFeatureFlagService;

use Miguel\FeatureFlags\Drivers\GrowthBook\GrowthBookDriver;
use Miguel\FeatureFlags\Exceptions\NotFoundException;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Factory\GrowthFactory;

/**
 *
 */
class StartGrowthServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itFailUrlNotExist()
    {
        $this->expectException(NotFoundException::class);

        $faker = \Faker\Factory::create();

        $url = $faker->url;
        new GrowthBookDriver($url);
    }


    /**
     * @test
     */
    public function itLoadFeatures():void {
        $service = $this->getGrowthFeatureFlagService();
        $service->__construct('');
         $this->assertTrue(!is_null($service->features()), " it should load features");
    }

    /**
     * @return Mock|(MockInterface&GrowthBookDriver)
     */
    public function getGrowthFeatureFlagService(string $feature = 'fast-track')
    {
        return GrowthFactory::make()
            ->addFeature($feature, true)
            ->mock();

    }
}