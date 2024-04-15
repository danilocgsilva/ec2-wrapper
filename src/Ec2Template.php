<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper;

use Danilocgsilva\Ec2Wrapper\Interfaces\Ec2TemplateInterface;

class Ec2Template implements Ec2TemplateInterface
{
    private string $keyName;

    private string $subnetId;

    private array $securityGroupsIds;
    
    /** @inheritDoc */
    public function getKeyName(): string
    {
        return $this->keyName;
    }

    /** @inheritDoc */
    public function getSecurityGroupsIds(): array
    {
        return $this->securityGroupsIds;
    }

    /** @inheritDoc */
    public function getSubnetId(): string
    {
        return $this->subnetId;
    }

    /** @inheritDoc */
    public function setKeyName(string $keyName): Ec2TemplateInterface
    {
        $this->keyName = $keyName;

        return $this;
    }

    /** @inheritDoc */
    public function setSecurityGroupsIds(array $securityGroupsIds): Ec2TemplateInterface
    {
        $this->securityGroupsIds = $securityGroupsIds;

        return $this;
    }

    /** @inheritDoc */
    public function setSubnetId(string $subnetId): Ec2TemplateInterface
    {
        $this->subnetId = $subnetId;

        return $this;
    }
}
