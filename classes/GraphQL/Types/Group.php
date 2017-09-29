<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\DateTimeType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Fields;

class Group extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'name' => new StringType(),
            'description' => new StringType(),
            'timeCreated' => new DateTimeType('c'),
            'timeUpdated' => new DateTimeType('c'),
            'tags' => new ListType(new StringType()),
            'membersCount' => new Fields\MembersCount(),
            'icon' => new Fields\Icon(),
            'url' => new Fields\Url(),
            'canWrite' => new Fields\CanWrite()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}