<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use GraphQL\Fields;

class Comment extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'description' => new StringType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'owner' => new Fields\Owner(),
            'canWrite' => new Fields\CanWrite()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}