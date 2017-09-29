<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;

class Bookmark extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'entity' => new Entity()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}