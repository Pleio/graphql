<?php
namespace GraphQL\Mutations\ForgotPassword;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'forgotPassword';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'username' => new StringType()
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        // check if logging in with email address
        if (strpos($username, '@') !== false && ($users = get_user_by_email($args['username']))) {
            $username = $users[0]->username;
        } else {
            $username = $args['username'];
        }

        $user = get_user_by_username($username);

        if ($user) {
            send_new_password_request($user->guid);
        }

        // do not give information about usernames, always return ok
        return Helpers::returnOk();
    }
}