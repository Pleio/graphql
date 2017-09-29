<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Enum\AbstractEnumType;

class ActivityTypeEnum extends AbstractEnumType {
    public function getName() {
        return "ActivityTypeEnum";
    }

    public function getValues() {
        return [
            [ "name" => "create", "value" => "create" ]
        ];
    }
}