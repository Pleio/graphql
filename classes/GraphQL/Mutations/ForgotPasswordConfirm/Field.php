<?php
namespace GraphQL\Mutations\ForgotPasswordConfirm;

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
        return 'forgotPasswordConfirm';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'username' => new NonNullType(new StringType()),
            'code' => new NonNullType(new StringType()),
            'password' => new NonNullType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $user = get_user_by_username($args['username']);

        if ($user) {
            $saved_code = $user->getPrivateSetting('passwd_conf_code');
            if ($saved_code && $saved_code == $conf_code) {
                remove_private_setting($user->guid, 'passwd_conf_code');
                reset_login_failure_count($user->guid);

                $user->setPassword($args['password']);

                try {
                    login($user);
                } catch (\LoginException $e) {
                    return Helpers::returnError("could_not_login", "Could not login due to an unknown error.");
                }
            }
        }

        // do not give information about usernames, always return ok
        return Helpers::returnOk();
    }
}