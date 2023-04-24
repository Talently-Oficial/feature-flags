<?php

namespace Talently\FeatureFlags\Drivers\GrowthBook;

use Growthbook\Growthbook;
use Talently\FeatureFlags\Contracts\FeatureFlagService;
use Talently\FeatureFlags\Data\Constants\ExceptionCode;
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
     * @var int
     */
    private $maxAttempts;

    /**
     * consume the growthbook api
     * @param string $url
     * @param int $maxAttempts
     */
    public function __construct(string  $url, int $maxAttempts = 3)
    {
        $this->maxAttempts = $maxAttempts;
        $this->features =  $this->loadFeatures($url);
        $this->global = $this->makeGrowthBook();

    }

    /**
     * load features from the api
     * @param string $url
     * @return array
     */
    public function loadFeatures(string $url): array
    {
        $feature = null;
        $intent = 1;
         while (is_null($feature) && $intent <= $this->maxAttempts){
            $feature = $this->tryToConnect($url, $feature);
             $intent++;
        }
        if (is_null($feature)){
            throw new NotFoundException("Features not found in the response object", ExceptionCode::NOT_FOUND);
        }

        return $feature;
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
        return json_decode(file_get_contents($url), true);
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

    /**
     * @param string $url
     * @param $feature
     * @param int $intent
     * @return array
     */
    public function tryToConnect(string $url, $feature): ?array
    {
        try {
            $apiResponse = $this->getResponse($url);
            if (!empty($apiResponse) && !empty($apiResponse["features"])) {
                return$apiResponse["features"];
            }
        }catch (\Exception $e) {
            return null;
        }
        return $feature;
    }
}