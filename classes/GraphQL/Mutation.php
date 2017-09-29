<?php
namespace GraphQL;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IntType;

class Mutation extends AbstractObjectType {
    public function getName() {
        return 'Mutation';
    }

    public function build($config) {
        $config->addFields([
            new Mutations\Register\Field(),
            new Mutations\Activate\Field(),
            new Mutations\Login\Field(),
            new Mutations\Logout\Field(),
            new Mutations\ForgotPassword\Field(),
            new Mutations\ForgotPasswordConfirm\Field(),
            new Mutations\UpdatePassword\Field(),
            new Mutations\UpdateEmail\Field(),
            new Mutations\UpdateEmailConfirm\Field(),
            new Mutations\UpdateProfileField\Field(),
            new Mutations\UpdateInterests\Field(),
            new Mutations\CreateNews\Field(),
            new Mutations\UpdateNews\Field(),
            new Mutations\CreateBlog\Field(),
            new Mutations\UpdateBlog\Field(),
            new Mutations\CreateDiscussion\Field(),
            new Mutations\UpdateDiscussion\Field(),
            new Mutations\CreateEvent\Field(),
            new Mutations\UpdateEvent\Field(),
            new Mutations\CreateGroup\Field(),
            new Mutations\UpdateGroup\Field(),
            new Mutations\JoinGroup\Field(),
            new Mutations\LeaveGroup\Field(),
            new Mutations\DeleteEntity\Field(),
            new Mutations\Like\Field(),
            new Mutations\UpdateBookmark\Field(),
            new Mutations\CreateComment\Field(),
            new Mutations\UpdateComment\Field(),
            new Mutations\UpdateIcon\Field()
        ]);
    }
}