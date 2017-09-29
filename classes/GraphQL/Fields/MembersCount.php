<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class MembersCount extends AbstractField {
    public function getName() {
        return 'membersCount';
    }

    public function getType() {
        return new IntType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $user = elgg_get_logged_in_user_entity();

        $guid = (int) $value['guid'];
        $data = get_data_row("SELECT COUNT(*) AS total FROM elgg_entity_relationships r WHERE relationship = 'member' AND r.guid_two = {$guid}
        ");

        return $data ? (int) $data->total : 0;
    }
}