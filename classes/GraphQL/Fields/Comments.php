<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Filter;
use GraphQL\Types;
use GraphQL\DataProvider;

class Comments extends AbstractField {
    public function getName() {
        return 'comments';
    }

    public function getType() {
        return new ListType(new Types\Comment());
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $options = [
            "type" => "object",
            "subtype" => "comment",
            "container_guid" => $value["guid"]
        ];

        $comments = elgg_get_entities($options);
        if (!$comments) {
            return [];
        }

        return Filter::getEntities($comments);
    }
}