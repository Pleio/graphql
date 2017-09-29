<?php
namespace GraphQL\Mutations\UpdateBookmark;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Types;

class Object extends AbstractObjectType {
    public function getName() {
        return 'UpdateBookmarkMutation';
    }

    public function build($config) {
        $config->addFields([
            'ok' => new BooleanType(),
            'errors' => new ListType(new Types\UserError()),
            'entity' => new Types\Entity()
        ]);
    }
}