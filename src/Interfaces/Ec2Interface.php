<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper\Interfaces;

interface Ec2Interface
{
    /**
     * Set region for EC2 object
     *
     * @param string $region
     * @return self
     */
    public function setRegion(string $region): self;
    
    /**
     * Get the EC2 region string
     *
     * @return string
     */
    public function getRegion(): string;

    /**
     * Get the instance public id
     *
     * @return string
     */
    public function getPublicId(): string;
}
