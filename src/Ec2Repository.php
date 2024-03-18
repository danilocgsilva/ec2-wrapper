<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper;

use Danilocgsilva\Ec2Wrapper\Interfaces\Ec2RepositoryInterface;
use Danilocgsilva\Ec2Wrapper\Ec2;
use Aws\Ec2\Ec2Client;
use Ramsey\Uuid\Uuid;
use Danilocgsilva\Ec2Wrapper\Ec2RepositoryResults;
use Aws\Result as AwsResult;

class Ec2Repository implements Ec2RepositoryInterface
{
    /** @var string */
    private string $region;

    private readonly Ec2Client $ec2Client;

    /** @inheritDoc */
    public function list(): array
    {
        $results = $this->ec2Client->describeInstances();
        
        return array_map(function ($entry) {
            $ec2 = new Ec2();
            $ec2->setRegion($this->region);
            return $ec2;
        }, $results['Reservations']);
    }

    /** @inheritDoc */
    public function setRegion(string $region): self
    {
        $this->region = $region;

        $this->ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => '2016-11-15'
        ]);

        return $this;
    }

    /** @inheritDoc */
    public function create(): void
    {

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
    function listSecurityGroups(): AwsResult
    {
        $results = $this->ec2Client->describeSecurityGroups();
        return $results;
    }
}