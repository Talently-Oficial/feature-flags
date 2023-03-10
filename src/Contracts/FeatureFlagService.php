<?php
declare(strict_types=1);

namespace Miguel\FeatureFlags\Contracts;


use Miguel\FeatureFlags\Data\Dtos\User;

interface FeatureFlagService
{
    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void;

    public function getUser(): ?User;

    /**
     * @param string $featureFlagName
     * @return bool
     */
    public function show(string $featureFlagName): bool;

    /**
     * @param string $featureFlagName
     * @param User $user
     * @return bool
     */
    public function showForUser(string $featureFlagName, User $user): bool;

    /**
     * @return string[]
     */
    public function features(): array;

    /**
     * @return array
     */
    public function dump(): array;
}