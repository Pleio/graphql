<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;

class Entity extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType()
        ]);
    }
}