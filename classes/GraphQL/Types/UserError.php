<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\ListType\ListType;

class UserError extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'key' => new StringType(),
            'message' => new StringType(),
        ]);
    }
}