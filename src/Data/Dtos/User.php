<?php
declare(strict_types=1);
namespace Miguel\FeatureFlags\Data\Dtos;

use Miguel\FeatureFlags\Shared\ArrayReflectionSerialize;

class User
{
    use ArrayReflectionSerialize;
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $guard;

    /**
     * @param int $id
     * @param string $email
     * @param string $guard
     */
    public function __construct(int $id, string $email, string $guard)
    {
        $this->id = $id;
        $this->email = $email;
        $this->guard = $guard;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;

    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;

    }

    /**
     * @return string
     */
    public function getGuard(): string
    {
        return $this->guard;
    }

    /**
     * @param string $guard
     * @return self
     */
    public function setGuard(string $guard): self
    {
        $this->guard = $guard;
        return $this;
    }
}