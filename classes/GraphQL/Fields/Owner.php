<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;
use GraphQL\Types;
use GraphQL\Filter;

class Owner extends AbstractField {
    public function getName() {
        return 'owner';
    }

    public function getType() {
        return new Types\User();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($value["guid"]);

        if (!$entity) {
            return null;
        }

        $owner = $entity->getOwnerEntity();

        return $owner ? Filter::getEntity($owner) : null;
    }
}
