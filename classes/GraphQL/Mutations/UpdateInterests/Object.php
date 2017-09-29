<?php
namespace GraphQL\Mutations\UpdateInterests;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Types;

class Object extends AbstractObjectType {
    public function getName() {
        return 'UpdateInterestsMutation';
    }

    public function build($config) {
        $config->addFields([
            'ok' => new BooleanType(),
            'errors' => new ListType(new Types\UserError()),
            'user' => new Types\User()
        ]);
    }
}