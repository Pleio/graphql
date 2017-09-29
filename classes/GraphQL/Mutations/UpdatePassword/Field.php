<?php
namespace GraphQL\Mutations\UpdatePassword;

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
        return 'updatePassword';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'oldPassword' => new NonNullType(new StringType()),
            'newPassword' => new NonNullType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $user = elgg_get_logged_in_user_entity();

        if (!$user) {
            return Helpers::returnError("not_logged_in", "The user is not logged in.");
        }

        $credentials = array(
            "username" => $user->username,
            "password" => $args['oldPassword']
        );

        try {
            pam_auth_userpass($credentials);
        } catch (\LoginException $e) {
            return Helpers::returnError("invalid_old_password", "The old password is not valid.");
        }

        if (!validate_password($newPassword)) {
            return Helpers::returnError("invalid_new_password", "The new password is not valid.");
        }

        $user->setPassword($newPassword);
        $user->code = "";

        if ($user->save()) {
            // @todo: send password changed message
            return Helpers::returnOk();
        } else {
            return Helpers::returnError("could_not_save", "Could not save the user.");
        }
    }
}