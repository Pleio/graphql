<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Enum\AbstractEnumType;

class EntityEnum extends AbstractEnumType {
    public function getName() {
        return "EntityEnum";
    }

    public function getValues() {
        return [
            [ "name" => "user", "value" => "user" ],
            [ "name" => "group", "value" => "group" ],
            [ "name" => "bookmark", "value" => "bookmark" ],
            [ "name" => "news", "value" => "news" ],
            [ "name" => "blog", "value" => "blog" ],
            [ "name" => "discussion", "value" => "discussion" ],
            [ "name" => "event", "value" => "event" ],
            [ "name" => "comment", "value" => "comment" ]
        ];
    }
}