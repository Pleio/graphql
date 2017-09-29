<?php
namespace GraphQL\Mutations\Logout;

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
        return 'logout';
    }

    public function getType() {
        return new Object();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        if (logout()) {
            return Helpers::returnOk();
        }

        return Helpers::returnError("could_not_logout", "Could not logout due to an unknown error.");
    }
}