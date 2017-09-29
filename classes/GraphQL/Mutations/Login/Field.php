<?php
namespace GraphQL\Mutations\Login;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Config\Field\FieldConfig;
use GraphQL\Helpers;

class Field extends AbstractField {
    public function getName() {
        return 'login';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'username' => new NonNullType(new StringType()),
            'password' => new NonNullType(new StringType()),
            'rememberMe' => new BooleanType()
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        // check if logging in with email address
        if (strpos($username, '@') !== false && ($users = get_user_by_email($args['username']))) {
            $username = $users[0]->username;
        } else {
            $username = $args['username'];
        }

        $result = elgg_authenticate($username, $args['password']);
        if ($result !== true) {
            return Helpers::returnError("could_not_login", "Could not login with the username and password combination.");
        }

        $user = get_user_by_username($username);

        if ($args['rememberMe']) {
            $rememberMe = true;
        } else {
            $rememberMe = false;
        }

        try {
            login($user, $rememberMe);
            unset($_SESSION['last_forward_from']);
            return Helpers::returnOk();
        } catch (\LoginException $e) {
            return Helpers::returnError("could_not_login", "Could not login due to an unknown error.");
        }

    }
}