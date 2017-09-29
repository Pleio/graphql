<?php
namespace GraphQL\Mutations\UpdateBookmark;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;
use GraphQL\Filter;

class Field extends AbstractField {
    public function getName() {
        return 'updateBookmark';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'guid' => new NonNullType(new IdType()),
            'isBookmarked' => new BooleanType()
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($args["guid"]);

        if (!$entity) {
            return Helpers::returnError("could_not_find", "Could not find the entity.");
        }

        $user = elgg_get_logged_in_user_entity();
        if (!$user) {
            return Helpers::returnError("not_logged_in", "The user is not logged in.");
        }

        if ($args['isBookmarked']) {
            $result = add_entity_relationship($user->guid, "bookmarked", $entity->guid);
        } else {
            $result = remove_entity_relationship($user->guid, "bookmarked", $entity->guid);
        }

        return Helpers::returnOk([
            "entity" => Filter::getEntity($entity)
        ]);
    }
}