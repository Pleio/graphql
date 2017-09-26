<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;

class BookmarkList extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'total' => new IntType(),
            'edges' => new ListType(new Bookmark())
        ]);
    }
}