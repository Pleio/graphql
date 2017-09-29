<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Enum\AbstractEnumType;

class GroupMembershipEnum extends AbstractEnumType {
    public function getName() {
        return "GroupMembershipEnum";
    }

    public function getValues() {
        return [
            [ "name" => "open", "value" => "open" ],
            [ "name" => "open_approval", "value" => "open_approval" ],
            [ "name" => "closed", "value" => "closed" ]
        ];
    }
}