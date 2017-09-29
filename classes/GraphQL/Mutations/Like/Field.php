<?php
namespace GraphQL\Mutations\Like;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'like';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'guid' => new NonNullType(new IdType()),
            'isLiked' => new BooleanType()
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

        $past_vote = elgg_get_annotations(array(
            "guid" => $entity->guid,
            "annotation_name" => "vote",
            "annotation_owner_guid" => $user->guid
        ));

        if ($args['isLiked'] && !$past_vote) {
            $entity->annotate("vote", "1", $entity->access_id);
        }

        if (!$args['isLiked'] && $past_vote) {
            $past_vote[0]->delete();
        }

        return Helpers::returnOk([
            "entity" => Filter::getEntity($entity)
        ]);
    }
}