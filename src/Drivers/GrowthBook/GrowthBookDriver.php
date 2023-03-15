<?php

namespace Talently\FeatureFlags\Drivers\GrowthBook;

use Growthbook\Growthbook;
use Talently\FeatureFlags\Contracts\FeatureFlagService;
use Talently\FeatureFlags\Data\Dtos\User;
use Talently\FeatureFlags\Exceptions\NotFoundException;

/**
 * Class GrowthBookDriver
 */
class GrowthBookDriver implements FeatureFlagService
{

    /**
     * list all features
     * @var array
     */
    private $features;

    /**
     * global growthbook instance
     * @var Growthbook
     */
    private $global;

    /**
     * global user
     * @var
     */
    private $user;

    /**
     * consume the growthbook api
     * @param string $url
     */
    public function __construct(string  $url)
    {
        $this->features =  $this->loadFeatures($url);
        $this->global = $this->makeGrowthBook();

    }

    /**
     * load features from the api
     * @param string $url
     * @return mixed
     */
    public function loadFeatures(string $url)
    {
        $apiResponse = $this->getResponse($url);


        if (empty($apiResponse) || empty($apiResponse["features"])){
            throw new NotFoundException("Features not found in the response");
        }
        return $apiResponse["features"];
    }

    /**
     * set a global user for the feature flag service
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->global =  $this->makeGrowthBook($user);
    }

    /**
     *
     * @param string $featureFlagName
     * @return bool
     */
    public function show(string $featureFlagName): bool
    {
        return  $this->global->isOn($featureFlagName);
    }

    /**
     *
     * @param string $featureFlagName
     * @param User $user
     * @return bool
     */
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

    /**
     * @return array
     */
    public function dump(): array
    {
        return  [
            'attributes' => $this->global->getAttributes(),
            'features' => $this->global->getFeatures(),
        ];
    }

    /**
     * @return array|string[]
     */
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

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Growthbook|null
     */
    public function getGlobal(): ?Growthbook
    {
        return $this->global;
    }
}