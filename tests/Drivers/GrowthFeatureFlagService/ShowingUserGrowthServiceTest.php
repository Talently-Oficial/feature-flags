<?php

namespace Tests\Drivers\GrowthFeatureFlagService;

use Faker\Factory;
use Miguel\FeatureFlags\Data\Dtos\User;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Factory\GrowthFactory;

/**
 *
 */
class ShowingUserGrowthServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itUser()
    {
        $faker = Factory::create();
        $user = new User(
            $faker->randomDigit(),
            $faker->email,
            $faker->word
        );
        $service = GrowthFactory::make()
            ->addFeature('fast-track', false, [
                    [
                        'condition'=>[
                            'email'=>$user->getEmail()
                        ],
                        'force'=>true,


                    ]
                ]
            )
            ->mock();
        $service->__construct('');


        $this->assertFalse($service->show('fast-track'), " it should show for user");

        $this->assertTrue($service->showForUser('fast-track', $user), " it false show for user");

        $service->setUser($user);

        $this->assertTrue($service->show('fast-track', $user), " it false show for user");
    }


}