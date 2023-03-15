<?php
declare(strict_types=1);

namespace Talently\FeatureFlags\Contracts;


use Talently\FeatureFlags\Data\Dtos\User;

/**
 * Interface FeatureFlagService
 * @package Talently\FeatureFlags\Contracts
 *
 */
interface FeatureFlagService
{
    /**
     * set a global user for the feature flag service
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void;

    /**
     * get the global user for the feature flag service
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * check if a feature flag is enabled
     * @param string $featureFlagName
     * @return bool
     */
    public function show(string $featureFlagName): bool;

    /**
     * check if a feature flag is enabled for a specific user
     * @param string $featureFlagName
     * @param User $user
     * @return bool
     */
    public function showForUser(string $featureFlagName, User $user): bool;

    /**
     * get all feature flags available for the global user
     * @return string[]
     */
    public function features(): array;

    /**
     * debug method to dump all feature flags and their values
     * @return array
     */
    public function dump(): array;
}