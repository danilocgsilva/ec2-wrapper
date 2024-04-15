# Ec2 wrapper

Note: you must have the key and secret from yout aws account, so you can access AWS services. The environment mus have the AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY variables, so the code can fetch data to access your services.

## Listing instances

```php
$ec2Repository = new Ec2Repository();
$ec2Repository->setRegion("us-east-1");
$ec2list = $ec2Repository->list();
```

## Creating a new instance

```php
$ec2Repository = new Ec2Repository();
$ec2Repository->setRegion("us-east-1");

$ec2Template = new Ec2Template();
$ec2Template->setKeyName('your-key-name');
$ec2Template->setSubnetId('subnet-your-subnet-id');
$ec2Template->setSecurityGroupsIds(['your-security-group']);

$ec2Repository->create($ec2Template);
```
