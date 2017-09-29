<?php
namespace GraphQL;

class Helpers {
    public static function returnOk($data = []) { 
        $status = [
            "ok" => true,
            "errors" => []
        ];

        return array_merge($status, $data);
    }

    public static function returnError($key, $message) {
        return [
            "ok" => false,
            "errors" => [
                [ "key" => $key, "message" => $message ]
            ]
        ];
    }

    public static function generateUsername($email) {
        list($username, $dummy) = explode("@", $email);
        $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);

        $hidden = access_get_show_hidden_status();
        access_show_hidden_entities(true);

        while (strlen($username) < 4) {
            $username .= "0";
        }

        if (get_user_by_username($username)) {
            $i = 1;

            while (get_user_by_username($username . $i)) {
                $i++;
            }

            $result = $username . $i;
        } else {
            $result = $username . $i;
        }

        access_show_hidden_entities($hidden);
        return $result;
    }

    public static function createEntity($type, $subtype = null, $args) {
        $user = elgg_get_logged_in_user_entity();

        if (!$user) {
            return Helpers::returnError("not_logged_in", "The user is not logged in.");
        }

        $site = elgg_get_site_entity();

        if (!Helpers::isUser()) {
            if (Helpers::canJoin()) {
                Helpers::addUser();
            } else {
                return Helpers::returnError("not_member_of_site", "The current user is not a member of the site.");
            }
        }

        $accessId = get_default_access();
        if ((int) $input["containerGuid"]) {
            $container = get_entity((int) $input["containerGuid"]);
            if ($container instanceof \ElggGroup && $container->membership === ACCESS_PRIVATE && $container->group_acl) {
                $accessId = $container->group_acl;
            }
        }

        switch ($type) {
            case "object":
                $entity = new \ElggObject();
                break;
            case "group":
                $entity = new \ElggGroup();
                break;
            default:
                throw new Exception("Invalid type specified.");
        }

        if (!$type && !$subtype) {
            throw new Exception("Subtype is not specified.");
        } else {
            $entity->subtype = $subtype;            
        }

        foreach (["name", "title", "description"] as $key) {
            if ($args[$key]) {
                $entity->$key = $args[$key];
            }
        }

        // for comments
        if ($args["entityGuid"]) {
            $entity->container_guid = $args["entityGuid"];
        }

        // for objects in groups
        if ($args["groupGuid"]) {
            $entity->container_guid = $args["groupGuid"];
        }

        if ($args["accessId"]) {
            $entity->access_id = $args["accessId"];
        } else {
            $entity->access_id = $accessId;
        }

        if ($args["tags"]) {
            $entity->tags = filter_tags($args["tags"]);
        }

        if ($args["source"]) {
            $entity->source = $args["source"];
        }

        $result = $entity->save();

        if (!$result) {
            return Helpers::returnError("could_not_save", "Could not save the entity.");
        }

        if ($type === "object") {
            add_to_river(
                "river/object/{$subtype}/create",
                "create",
                elgg_get_logged_in_user_guid(),
                $entity->guid,
                $entity->access_id
            );
        }

        if ($type === "group") {
            $entity->join($user);
        }

        return Helpers::returnOk([
            "entity" => Filter::getEntity($entity)
        ]);
    }

    public static function updateEntity($args) {
        $entity = get_entity($args["guid"]);

        if (!$entity) {
            return Helpers::returnError("could_not_find", "Can not find the specified entity.");
        }

        if (!elgg_is_logged_in()) {
            return Helpers::returnError("not_logged_in", "The user is not logged in.");
        }

        if (!$entity->canEdit()) {
            return Helpers::returnError("could_not_save", "Can not edit the specified entity.");
        }

        if (!in_array($entity->type, ["group", "object"])) {
            return Helpers::returnError("invalid_object_type", "Can not edit this kind of entity.");
        }

        if ($args["name"]) {
            $entity->name = $args["name"];
        }

        if ($args["title"]) {
            $entity->title = $args["title"];
        }

        if ($args["description"]) {
            $entity->description = $args["description"];
        }

        if ($args["containerGuid"]) {
            $entity->container_guid = $args["containerGuid"];
        }

        if ($args["accessId"]) {
            $entity->accessId = $args["accessId"];
        }

        if ($args["tags"]) {
            $entity->tags = filter_tags($args["tags"]);
        }

        if ($args["source"]) {
            $entity->source = $args["source"];
        }

        if ($entity->save()) {
            return Helpers::returnOk();
        } else {
            return Helpers::returnError("could_not_save", "Could not save the entity.");
        }
    }

    public static function deleteEntity($guid) {
        $entity = get_entity($guid);

        if (!$entity) {
            return Helpers::returnError("could_not_find", "Can not find the specified entity.");
        }

        if (!elgg_is_logged_in()) {
            return Helpers::returnError("not_logged_in", "The user is not logged in.");
        }

        if (!$entity->canEdit()) {
            return Helpers::returnError("could_not_delete", "Can not delete the specified entity.");
        }

        if ($entity->delete()) {
            return Helpers::returnOk();
        } else {
            return Helpers::returnError("could_not_delete", "Could not save the entity.");
        }
    }

    public static function isUser() {
        $user = elgg_get_logged_in_user_entity();
        if (!$user) {
            return false;
        }

        return check_entity_relationship($user->guid, "member_of_site", $site->guid);
    }

    public static function canJoin() {
        // method exposed in subsite_manager
        if (method_exists($site, "canJoin")) {
            return $site->canJoin();
        }

        return elgg_get_config("allow_registration");
    }

    public static function addUser() {
        $user_guid = elgg_get_logged_in_user_guid();
        if ($user_guid) {
            $site = elgg_get_site_entity();
            return $site->addUser($user_guid);
        }

        return false;
    }

    public static function formatTags($tags) {
        if (!$tags) {
            return [];
        }

        if (is_array($tags)) {
            return $tags;
        } else {
            return [$tags];
        }
    }
}