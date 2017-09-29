<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class Likes extends AbstractField {
    public function getName() {
        return 'likes';
    }

    public function getType() {
        return new IntType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $options = [
            "guid" => $value["guid"],
            "annotation_name" => "vote",
            "annotation_calculation" => "sum",
            "limit" => false
        ];

        $count = elgg_get_annotations($options);

        return $count ? (int) $count : 0;
    }
}