<?php

namespace Tests\Shared\Factory;

use Talently\FeatureFlags\Drivers\GrowthBook\GrowthBookDriver;
use Mockery\Mock;
use Mockery\MockInterface;

/**
 * make a groth faker instance
 */
class GrowthFactory
{
    /**
     * @var array
     */
    private $features = [];

    /**
     * @return Mock|(MockInterface&GrowthBookDriver)
     */
    public  function mock(){
        $service = $this->partialMock();

         $service->shouldReceive('getResponse')
            ->once()
            ->andReturn([
                'features' => $this->features
            ]);
        return $service;
    }

    public function partialMock() {
       return  \Mockery::mock(GrowthBookDriver::class)
            ->makePartial();
    }

    /**
     * @param string $featureName
     * @param bool $defaultValue
     * @param array $rules
     * @return $this
     */
    public function addFeature(
        string $featureName,
        bool $defaultValue, array $rules = []): self
    {
        $facture = [
            'defaultValue' => $defaultValue,
        ];
        if (!empty($rules)) {
            $facture['rules'] = $rules;
        }
        $this->features[$featureName] = $facture;
        return $this;
    }

    /**
     * @return static
     */
    public static function make(): self
    {
        return new self();
    }
}