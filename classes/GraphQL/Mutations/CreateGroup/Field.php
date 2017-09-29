<?php
namespace GraphQL\Mutations\CreateGroup;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Types;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'createGroup';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'name' => new NonNullType(new StringType()),
            'membership' => new Types\GroupMembershipEnum(),
            'icon' => new StringType(),
            'description' => new NonNullType(new StringType()),
            'tags' => new ListType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        return Helpers::createEntity("group", null, $args);
    }
}