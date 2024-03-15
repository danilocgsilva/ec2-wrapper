<?php

declare(strict_types=1);

namespace Danilocgsilva\EC2Wrapper;

use Danilocgsilva\Interfaces\EC2Wrapper\EC2RepositoryInterface;
use Danilocgsilva\EC2Wrapper\Ec2;
use Aws\Ec2\Ec2Client;

class EC2Repository implements EC2RepositoryInterface
{
    /** @var string */
    private string $region;

    private readonly Ec2Client $ec2Client;

    public function __construct()
    {
        $this->ec2Client = new Ec2Client([
            'region' => $this->region,
            'version' => '2016-11-15',
            'profile' => 'default'
        ]);

        // $this->ec2Client = Ec2Client::factory([
        //     'key' => 'key',
        //     'secret' => 'secret',
        //     'region' => 'region'
        // ]);
    }

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
        return $this;
    }

    public function create()
    {

    }
}