<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Enum\AbstractEnumType;

class GroupFilterEnum extends AbstractEnumType {
    public function getName() {
        return "GroupFilterEnum";
    }

    public function getValues() {
        return [
            [ "name" => "all", "value" => "all" ],
            [ "name" => "mine", "value" => "mine" ]
        ];
    }
}