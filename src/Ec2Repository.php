<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper;

use Danilocgsilva\Ec2Wrapper\Exceptions\MissingRegionException;
use Danilocgsilva\Ec2Wrapper\Interfaces\Ec2RepositoryInterface;
use Danilocgsilva\Ec2Wrapper\Ec2;
use Aws\Ec2\Ec2Client;
use Ramsey\Uuid\Uuid;
use Danilocgsilva\Ec2Wrapper\Ec2RepositoryResults;
use Aws\Result as AwsResult;
use ReflectionProperty;
use Danilocgsilva\Ec2Wrapper\Interfaces\Ec2TemplateInterface;

class Ec2Repository implements Ec2RepositoryInterface
{
    /** @var string */
    private string $region;

    /** @var string */
    private string $profile;

    private readonly Ec2Client $ec2Client;

    /** @inheritDoc */
    public function list(): array
    {
        $this->resolveClient();

        $results = $this->ec2Client->describeInstances();
        $reservations = $results->get('Reservations');
        
        return array_map(function ($entry) {
            $ec2 = new Ec2();
            $ec2->setRegion($this->region);
            $ec2->setInstanceId($entry["Instances"][0]["InstanceId"]);
            return $ec2;
        }, $reservations);
    }

    /** @inheritDoc */
    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /** @inheritDoc */
    public function setProfile(string $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /** @inheritDoc */
    public function create(Ec2TemplateInterface $ec2Template): void
    {
        $this->resolveClient();

        $result = $this->ec2Client->runInstances(array(
            'ImageId'        => 'ami-0b660115243d1c4b6',
            'MinCount'       => 1,
            'MaxCount'       => 1,
            'InstanceType'   => 't4g.nano',
            'KeyName'        => $ec2Template->getKeyName(),
            'SecurityGroupsIds' => $ec2Template->getSecurityGroupsIds(),
            'SubnetId' => $ec2Template->getSubnetId()
        ));
    }

    /** @inheritDoc */
    function createSecurityGroup(): Ec2RepositoryResults
    {
        $myuuid = Uuid::uuid4();
        $stringMyUuId = $myuuid->toString();
        $dataMethod = [
            'Description' => $stringMyUuId,
            'GroupName' => $stringMyUuId
        ];
        
        $resultsSecurityGroupCreation = $this->ec2Client->createSecurityGroup([
            'Description' => $dataMethod['Description'],
            'GroupName' => $dataMethod['GroupName']
        ]);

        $resultIngress = $this->ec2Client->authorizeSecurityGroupIngress([
            'GroupName' => $dataMethod['GroupName'],
            'IpPermissions' => [
                [
                    'IpProtocol' => "tcp",
                    'IpRanges' => [
                        [
                            "CidrIp" => "0.0.0.0/0"
                        ]
                    ],
                    'FromPort' => 80,
                    'ToPort' => 80
                ]
            ],
        ]);

        return new Ec2RepositoryResults(
            [
                $resultsSecurityGroupCreation,
                $resultIngress
            ],
            $dataMethod
        );
    }

    /** @inheritDoc */
    public function listSecurityGroups(): AwsResult
    {
        $results = $this->ec2Client->describeSecurityGroups();
        return $results;
    }

    private function resolveClient(): void
    {
        if (!$this->checkClientInitialization()) {
            $this->initializesClient();
        }
    }

    private function initializesClient()
    {
        $region = $this->region ?? null;
        $profile = $this->profile ?? null;
    
        if (empty($region)) {
            throw new MissingRegionException();
        }
    
        $clientConfig = [
            'region' => $region,
            'version' => '2016-11-15'
        ];
    
        if (!empty($profile)) {
            $clientConfig['profile'] = $profile;
        }
    
        $this->ec2Client = new Ec2Client($clientConfig);
    }

    private function checkClientInitialization(): bool
    {
        $clientInitialization = new ReflectionProperty($this, 'ec2Client');
        return $clientInitialization->isInitialized($this);
    }
}