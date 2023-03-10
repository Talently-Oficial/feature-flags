<?php

namespace Miguel\FeatureFlags\Drivers\GrowthBook;

use Growthbook\Growthbook;
use Miguel\FeatureFlags\Contracts\FeatureFlagService;
use Miguel\FeatureFlags\Data\Dtos\User;
use Miguel\FeatureFlags\Exceptions\NotFoundException;

class GrowthBookDriver implements FeatureFlagService
{

    private $features;
    private $global;

    private $user;

    /**
     * @param string $url
     */
    public function __construct(string  $url)
    {
        $this->features =  $this->loadFeatures($url);
        $this->global = $this->makeGrowthBook();

    }

    public function loadFeatures(string $url)
    {
        $apiResponse = $this->getResponse($url);


        if (empty($apiResponse) || empty($apiResponse["features"])){
            throw new NotFoundException("Features not found in the response");
        }
        return $apiResponse["features"];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->global =  $this->makeGrowthBook($user);
    }

    public function show(string $featureFlagName): bool
    {
        return  $this->global->isOn($featureFlagName);
    }

    public function showForUser(string $featureFlagName, User $user): bool
    {
        return $this->makeGrowthBook($user)->isOn($featureFlagName);
    }

    /**
     * @param User|null $user
     * @return Growthbook
     */
    public function makeGrowthBook(?User  $user = null): Growthbook
    {
        $instance =  Growthbook::create()
            ->withFeatures($this->features)
        ;

        if ($user) {
            $instance->withAttributes($user->toArray());
        }
        return  $instance;
    }

    public function dump(): array
    {
        return  [
            'attributes' => $this->global->getAttributes(),
            'features' => $this->global->getFeatures(),
        ];
    }

    public function features(): array
    {
        $features = [];
        foreach ($this->global->getFeatures() as $k => $feature) {
            if (self::show($k))
                $features[] = $k;
        }
        return  $features;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function getResponse(string $url)
    {
        try
        {
            return json_decode(file_get_contents($url), true);
        } catch (\Exception $e) {
            throw new NotFoundException("Features not found in the response");
        }
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getGlobal(): ?Growthbook
    {
        return $this->global;
    }
}