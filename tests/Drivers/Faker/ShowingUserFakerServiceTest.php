<?php

namespace Tests\Drivers\Faker;

use PHPUnit\Framework\TestCase;
use Talently\FeatureFlags\Data\Dtos\User;
use Talently\FeatureFlags\Drivers\FakerService\FakerService;

/**
 * Class ShowingUserFakerServiceTest
 */
class ShowingUserFakerServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itUser()
    {
        $service = new FakerService([
            'fast-track' =>  false
        ]);

        $user = new User(1, 'test', 'test');


        $this->assertFalse($service->show('fast-track'), " it should show for user");

        $service->setFeature('fast-track', true);

        $this->assertTrue($service->showForUser('fast-track', $user), " it false show for user");

        $service->setUser($user);

        $this->assertTrue($service->show('fast-track'), " it false show for user");
    }


}