<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper;

use Danilocgsilva\Ec2Wrapper\Interfaces\Ec2Interface;

class Ec2 implements Ec2Interface
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