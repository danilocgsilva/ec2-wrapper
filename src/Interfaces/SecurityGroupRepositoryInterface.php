<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper\Interfaces;

interface SecurityGroupRepositoryInterface
{
    /**
     * List Security Groups
     *
     * @return \Danilocgsilva\EC2Wrapper\Interfaces\SecurityGroupInterface[]
     */
    public function list(): array;
}
