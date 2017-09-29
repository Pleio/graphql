<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use GraphQL\DataProvider;

class CanWrite extends AbstractField {
    public function getName() {
        return 'canWrite';
    }

    public function getType() {
        return new BooleanType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($value["guid"]);
        return $entity ? $entity->canEdit() : false;
    }
}