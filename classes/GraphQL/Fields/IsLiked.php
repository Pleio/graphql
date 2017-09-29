<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class IsLiked extends AbstractField {
    public function getName() {
        return 'isLiked';
    }

    public function getType() {
        return new BooleanType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $user = elgg_get_logged_in_user_entity();

        $options = [
            "guid" => $value["guid"],
            "annotation_name" => "vote",
            "annotation_owner_guid" => $user->guid,
            "limit" => 1
        ];

        if ($user && elgg_get_annotations($options)) {
            return true;
        }

        return false;
    }
}