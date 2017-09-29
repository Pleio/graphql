<?php
namespace GraphQL\Mutations\UpdateEmail;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'updateEmail';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'newEmail' => new NonNullType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        // @todo
    }
}