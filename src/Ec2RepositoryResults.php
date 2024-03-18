<?php

declare(strict_types=1);

namespace Danilocgsilva\Ec2Wrapper;

use Aws\Result as AwsResult;

class Ec2RepositoryResults
{
    public function __construct(
        public readonly array $awsResults,
        public readonly array $dataMethod
    ) {}
}