<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\ListType\ListType;

class BookmarkList extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'total' => new IntType(),
            'edges' => new ListType(new Bookmark())
        ]);
    }
}