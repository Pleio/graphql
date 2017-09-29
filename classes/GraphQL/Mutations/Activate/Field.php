<?php
namespace GraphQL\Mutations\Activate;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'activate';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'code' => new NonNullType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        // @todo: implement
    }
}