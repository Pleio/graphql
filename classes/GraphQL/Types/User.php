<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\ListType\ListType;

class User extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'email' => new StringType(),
            'name' => new StringType(),
            'icon' => new StringType(),
            'url' => new StringType(),
            'profile' => new ListType(new ProfileItem())
        ]);
    }
}