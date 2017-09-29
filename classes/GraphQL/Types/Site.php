<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Fields;

class Site extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'name' => new StringType(),
            'profileFields' => new ListType(new ProfileField()),
            'canWrite' => new Fields\CanWrite()
        ]);
    }
}