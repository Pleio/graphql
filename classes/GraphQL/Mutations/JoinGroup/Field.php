<?php
namespace GraphQL\Mutations\JoinGroup;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'joinGroup';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'guid' => new NonNullType(new IdType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $group = get_entity($args['guid']);

        if (!$group || !$group instanceof \ElggGroup) {
            return Helpers::returnError("could_not_find", "Could not find the entity.");
        }

        $user = elgg_get_logged_in_user_entity();
        if (!$user) {
            return returnError("not_logged_in", "The user is not logged in.");
        }

        if ($group->isPublicMembership() || $group->canEdit()) {
            groups_join_group($group, $user);
        } else {
            add_entity_relationship($user->guid, "membership_request", $group->guid);
        }

        return Helpers::returnOk();
    }
}