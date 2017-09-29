<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\ListType\ListType;
use GraphQL\Fields;

class User extends AbstractObjectType {
    public function build($config) {
        $config->addFields([
            'guid' => new IdType(),
            'email' => new StringType(),
            'name' => new StringType(),
            'icon' => new Fields\Icon(),
            'url' => new Fields\Url(),
            'profile' => new ListType(new ProfileItem()),
            'canWrite' => new Fields\CanWrite(),
            'answerCount' => new IntType(),
            'voteCount' => new IntType(),
            'newsletter' => new BooleanType(),
            'notifications' => new BooleanType()
        ]);
    }

    public function getInterfaces() {
        return [new Entity()];
    }
}