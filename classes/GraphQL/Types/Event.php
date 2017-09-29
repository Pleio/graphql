<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Fields;

class Event extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'title' => new StringType(),
            'description' => new StringType(),
            'slug' => new Fields\Slug(),
            'summary' => new StringType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'tags' => new ListType(new StringType()),
            'owner' => new Fields\Owner(),
            'url' => new Fields\Url(),
            'commentsCount' => new Fields\CommentsCount(),
            'comments' => new Fields\Comments(),
            'isBookmarked' => new Fields\isBookmarked(),
            'canWrite' => new Fields\CanWrite()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}