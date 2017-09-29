<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use GraphQL\Types;

class Activity extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'entity' => new Entity(),
            'type' => new Types\ActivityTypeEnum(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
        ]);
    }
}