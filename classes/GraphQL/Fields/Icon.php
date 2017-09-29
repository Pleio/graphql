<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class Icon extends AbstractField {
    public function getName() {
        return 'icon';
    }

    public function getType() {
        return new StringType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($value['guid']);
        return $entity ? $entity->getIconURL() : "";
    }
}