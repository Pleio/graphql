<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\Scalar\StringType;
use GraphQL\Types;
use GraphQL\DataProvider;

class Slug extends AbstractField {
    public function getName() {
        return 'slug';
    }

    public function getType() {
        return new StringType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($value["guid"]);
        return $entity->description;
    }
}