<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\Scalar\IntType;
use GraphQL\DataProvider;

class CommentsCount extends AbstractField {
    public function getName() {
        return 'commentsCount';
    }

    public function getType() {
        return new IntType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $options = [
            "type" => "object",
            "subtype" => "comment",
            "container_guid" => $value["guid"],
            "count" => true
        ];

        return elgg_get_entities($options) ?: 0;
    }
}