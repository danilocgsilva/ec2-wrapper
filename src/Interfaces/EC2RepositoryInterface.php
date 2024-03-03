<?php

declare(strict_types=1);

namespace Danilocgsilva\Interfaces\EC2Wrapper;

interface EC2RepositoryInterface
{
    /**
     * List ec2 instances. The object must have a region setted before.
     *
     * @return \Danilocgsilva\Interfaces\EC2Wrapper\EC2Interface[]
     */
    public function list(): array;

    /**
     * Set a region, se repository know from which region it should fetches data.
     *
     * @param string $region
     * @return void
     */
    public function setRegion(string $region): self;
}