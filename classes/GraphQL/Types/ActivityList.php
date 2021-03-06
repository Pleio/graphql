<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\ListType\ListType;

class ActivityList extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'total' => new IntType(),
            'edges' => new ListType(new Activity())
        ]);
    }
}