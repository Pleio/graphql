<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use GraphQL\Fields;

class News extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'title' => new StringType(),
            'description' => new StringType(),
            'summary' => new StringType(),
            'source' => new StringType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'tags' => new ListType(new StringType()),
            'owner' => new Fields\Owner(),
            'url' => new Fields\Url(),
            'isBookmarked' => new Fields\IsBookmarked(),
            'canWrite' => new Fields\CanWrite()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}