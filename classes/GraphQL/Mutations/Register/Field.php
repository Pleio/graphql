<?php
namespace GraphQL\Mutations\Register;

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
        return 'register';
    }

    public function getType() {
        return new Object();
    }

    public function build(FieldConfig $config) {
        $config->addArguments([
            'name' => new NonNullType(new StringType()),
            'email' => new NonNullType(new StringType()),
            'password' => new NonNullType(new StringType()),
            'newsletter' => new NonNullType(new BooleanType()),
            'terms' => new NonNullType(new BooleanType()),
            'tags' => new ListType(new StringType())
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info) {
        $ia = access_show_hidden_entities(true);
        $user = get_user_by_email($args['email']);
        access_show_hidden_entities($ia);

        if ($user) {
            return Helpers::returnError("already_registered", "This email is already in use.");
        }

        $username = Helpers::generateUsername($args['email']);
        $guid = register_user($username, $args['password'], $args['name'], $args['email'], false);
        if ($guid) {
            $new_user = get_entity($guid);
            $site = elgg_get_site_entity();

            $ia = elgg_set_ignore_access(true);

            if ($args['tags']) {
                $new_user->tags = filter_tags($args['tags']);
            }

            if ($newsletter) {
                add_entity_relationship($guid, "subscribed", $site->guid);
            }

            if ($args['terms']) {
                $new_user->setPrivateSetting("general_terms_accepted", time());
            }

            elgg_set_ignore_access($ia);

            $params = array(
                'user' => $new_user,
                'password' => $password
            );

            // @todo should registration be allowed no matter what the plugins return?
            if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
                $ia = elgg_set_ignore_access(true);
                $new_user->delete();
                elgg_set_ignore_access($ia);
                // @todo this is a generic messages. We could have plugins
                // throw a RegistrationException, but that is very odd
                // for the plugin hooks system.
                throw new \RegistrationException(elgg_echo('registerbad'));
            }

            return Helpers::returnOk();
        } else {
            return Helpers::returnError("could_not_register", "Could not register the user.");
        }
    }
}