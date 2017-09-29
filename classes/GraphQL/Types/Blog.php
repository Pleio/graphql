<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Fields;

class Blog extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'title' => new StringType(),
            'description' => new StringType(),
            'summary' => new StringType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'tags' => new ListType(new StringType()),
            'owner' => new Fields\Owner(),
            'url' => new Fields\Url(),
            'isLiked' => new Fields\IsLiked(),
            'likes' => new Fields\Likes(),
            'isBookmarked' => new Fields\IsBookmarked(),
            'canWrite' => new Fields\CanWrite(),
            'commentsCount' => new Fields\CommentsCount(),
            'comments' => new Fields\Comments()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}