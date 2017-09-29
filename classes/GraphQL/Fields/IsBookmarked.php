<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class IsBookmarked extends AbstractField {
    public function getName() {
        return 'isBookmarked';
    }

    public function getType() {
        return new BooleanType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $user = elgg_get_logged_in_user_entity();

        if ($user && check_entity_relationship($user->guid, "bookmarked", $value['guid'])) {
            return true;
        }

        return false;
    }
}