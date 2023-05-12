<?php

namespace Talently\FeatureFlags\Drivers\FakerService;

use Talently\FeatureFlags\Contracts\FeatureFlagService;
use Talently\FeatureFlags\Data\Dtos\User;

class FakerService implements FeatureFlagService
{

    private $config;
    /**
     * @var User
     */
    private $user;

    /**
     * @param array $config
     * [{nameFeature: true}, {nameFeature: false}]
     */
    public function __construct(array $config)
    {
        $this->config = $config;
     }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function show(string $featureFlagName): bool
    {
        return $this->config[$featureFlagName] ?? false;
    }

    public function showForUser(string $featureFlagName, User $user): bool
    {
        return $this->config[$featureFlagName] ?? false;
    }

    public function features(): array
    {
        return $this->config;
    }

    public function setFeatures(array $features): void
    {
        $this->config = $features;
    }


    public function setFeature(string $featureFlagName, bool $value): void
    {
        $this->config[$featureFlagName] = $value;
    }

    public function dump(): array
    {
       return  [
              'user' => $this->user,
              'features' => $this->config
       ];
    }
}