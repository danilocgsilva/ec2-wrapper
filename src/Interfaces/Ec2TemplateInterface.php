<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper\Interfaces;

interface Ec2TemplateInterface
{
    /**
     * Set key name
     *
     * @param string $keyName
     * @return self
     */
    public function setKeyName(string $keyName): self;

    /**
     * Get key name.
     *
     * @return string
     */
    public function getKeyName(): string;

    /**
     * Set security groups.
     *
     * @param array $securityGroups
     * @return self
     */
    public function setSecurityGroupsIds(array $securityGroupsIds): self;

    /**
     * Get security groups ids
     *
     * @return array
     */
    public function getSecurityGroupsIds(): array;

    /**
     * Set subnet id
     *
     * @param string $subnetId
     * @return self
     */
    public function setSubnetId(string $subnetId): self;

    /**
     * Get subnet id
     *
     * @return string
     */
    public function getSubnetId(): string;
}
