<?php
namespace GraphQL\Mutations\JoinGroup;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Types;

class Object extends AbstractObjectType {
    public function getName() {
        return 'JoinGroupMutation';
    }

    public function build($config) {
        $config->addArguments([
            'guid' => new NonNullType(new IdType())
        ]);
    }
}