<?php
namespace GraphQL;

class DataProvider {
    public static function getSite() {
        $site = elgg_get_site_entity();

        return [
            "guid" => $site->guid,
            "name" => $site->name,
            "profileFields" => []
        ];
    }

    public static function getViewer() {
        $user = elgg_get_logged_in_user_entity();

        return [
            "guid" => "0",
            "loggedIn" => $user ? true : false,
            "user" => [
                "guid" => $user ? $user->guid : null,
                "email" => $user ? $user->email : null,
                "name" => $user ? $user->name : null,
                "icon" => $user ? $user->getIconURL() : null,
                "url" => $user ? $user->getURL() : null,
                "profile" => []
            ]
        ];
    }

    public static function getActivityList($source, $args) {
        $options = [
            "subtypes" => ["news", "blog", "discussion", "event"],
            "offset" => $args["offset"],
            "limit" => $args["limit"]
        ];

        $groupGuid = (int) $args["groupGuid"];
        if ($groupGuid) {
            $options["joins"] = ["JOIN elgg_entities e ON rv.object_guid = e.guid"];
            $options["wheres"] = ["e.container_guid = {$groupGuid}"];
        }

        $total = elgg_get_river(array_merge($options, ["count" => true])) ?: 0;
        $activities = elgg_get_river($options);

        return [
            "total" => $total,
            "edges" => Filter::getActivities($activities)
        ];
    }

    public static function getBookmarkList($source, $args) {
        $user = elgg_get_logged_in_user_entity();

        if (!$user) {
            return [
                "total" => 0,
                "edges" => []
            ];
        }

        $options = [
            "relationship_guid" => $user->guid,
            "relationship" => "bookmarked",
            "offset" => $args["offset"],
            "limit" => $args["limit"],
            "order_by" => "r.id DESC"
        ];

        $total = elgg_get_entities(array_merge($options, ["count" => true])) ?: 0;
        $entities = elgg_get_entities_from_relationship($options);

        return [
            "total" => $total,
            "edges" => Filter::getEntities($entities)
        ];
    }

    public static function getEntity($source, $args) {
        $entity = get_entity($args["guid"]);

        if ($entity) {
            return Filter::getEntity($entity);            
        }

        return null;
    }

    public static function getEntityList($source, $args) {
        switch ($args["entityType"]) {
            case "user":
            case "group":
                $type = $args["entityType"];
                $subtype = null;
                break;
            default:   
                $type = "object";
                $subtypes = $args["entityType"] ? $args["entityType"] : ["news", "blog", "discussion", "event"];
                break;
        }

        $options = [
            "type" => $type,
            "subtypes" => $subtypes,
            "offset" => $args["offset"],
            "limit" => $args["limit"]
        ];

        if ($args["groupGuid"]) {
            $options["container_guid"] = $args["groupGuid"];
        }

        $total = elgg_get_entities(array_merge($options, ["count" => true])) ?: 0;
        $entities = elgg_get_entities($options);
        if (!$entities) {
            $entities = [];
        }

        return [
            "total" => $total,
            "edges" => Filter::getEntities($entities)
        ];
    }

    public static function getGroupList($source, $args) {
        $options = [
            "type" => "group",
            "offset" => $args["offset"],
            "limit" => $args["limit"]
        ];

        $total = elgg_get_entities(array_merge($options, ["count" => true])) ?: 0;
        $entities = elgg_get_entities($options);
        if (!$entities) {
            $entities = [];
        }

        return [
            "total" => $total,
            "edges" => Filter::getEntities($entities)
        ];
    }

    public static function getSearchList($source, $args) {
        return [
            "total" => 0,
            "edges" => []
        ];
    }
}