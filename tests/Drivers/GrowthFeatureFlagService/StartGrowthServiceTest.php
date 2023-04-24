<?php

namespace Tests\Drivers\GrowthFeatureFlagService;

use Talently\FeatureFlags\Drivers\GrowthBook\GrowthBookDriver;
use Talently\FeatureFlags\Exceptions\NotFoundException;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Factory\GrowthFactory;

/**
 * Class StartGrowthServiceTest
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
     * @test
     */
    public function itLoadFeaturesAttempts():void {
        $service = GrowthFactory::make()
            ->partialMock()
        ;

        $service->shouldReceive('getResponse')
            ->andReturn(null);

        $service
            ->shouldReceive('tryToConnect')
            ->withArgs([
                '',
                null
            ])
            ->andReturn([
                'fast-track' => [
                    'defaultValue' => true
                ]
            ]);

        $service->__construct('');
        $features = $service->features();

        $this->assertNotEmpty($features, " it should load features");
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