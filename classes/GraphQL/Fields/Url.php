<?php
namespace GraphQL\Fields;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\DataProvider;

class Url extends AbstractField {
    public function getName() {
        return 'url';
    }

    public function getType() {
        return new StringType();
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $entity = get_entity($value["guid"]);

        if (!$entity) {
            return "";
        }

        switch ($entity->type) {
            case "user":
                return "/profile/{$entity->guid}";
            case "group":
                $friendly_title = elgg_get_friendly_title($entity->name);
                return "/groups/view/{$entity->guid}/{$friendly_title}";
            case "object":
                $friendly_title = elgg_get_friendly_title($entity->title);
                $translate = [
                    "news" => "news",
                    "blog" => "blog",
                    "discussion" => "discussions",
                    "event" => "events"
                ];

                if (!$translate[$entity->getSubtype()]) {
                    return "";
                }

                return "/{$translate[$entity->getSubtype()]}/view/{$entity->guid}/{$friendly_title}";
        }
    }
}
