<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;

class ProfileItem extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'id' => new IdType(),
            'key' => new StringType(),
            'value' => new StringType()
        ]);
    }
}