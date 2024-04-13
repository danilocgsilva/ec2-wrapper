<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper\Interfaces;

use Danilocgsilva\Ec2Wrapper\Ec2RepositoryResults;
use Aws\Result as AwsResult;

interface Ec2RepositoryInterface
{
    /**
     * List ec2 instances. The object must have a region setted before.
     *
     * @return \Danilocgsilva\EC2Wrapper\Interfaces\Ec2Interface[]
     */
    public function list(): array;

    /**
     * Set a region, se repository know from which region it should fetches data.
     *
     * @param string $region
     * @return void
     */
    public function setRegion(string $region): self;

    /**
     * Set a profile, if the profile is setted on the environment
     *
     * @param string $profile
     * @return self
     */
    public function setProfile(string $profile): self;

    /**
     * Creates an ec2 instance
     */
    public function create(): void;

    /**
     * Create a security group
     *
     * @return \Danilocgsilva\Ec2Wrapper\Ec2RepositoryResults
     */
    public function createSecurityGroup(): Ec2RepositoryResults;

    /**
     * Lists a security group
     * 
     * @return \Aws\Result
     */
    public function listSecurityGroups(): AwsResult;
}