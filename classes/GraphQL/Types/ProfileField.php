<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;

class ProfileField extends AbstractObjectType {
    public function getName() {
        return "ProfileField";
    }

    public function build($config) {
        $config->addFields([
            'id' => new IdType(),
            'key' => new StringType(),
            'name' => new StringType()
        ]);
    }
}