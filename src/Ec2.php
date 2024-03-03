<?php

declare(strict_types=1);

namespace Danilocgsilva\EC2Wrapper;
use Danilocgsilva\Interfaces\EC2Wrapper\EC2Interface;

class Ec2 implements EC2Interface
{
    /** @var string */
    private string $region;
    
    /** @inheritDoc */
    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    /** @inheritDoc */
    public function getPublicId(): string
    {
        return "";
    }
}