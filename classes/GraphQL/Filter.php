<?php
namespace GraphQL;

class Filter {
    public static function getActivities($activities) {
        $result = [];
        foreach ($activities as $activity) {
            $result[] = Filter::getActivity($activity);
        }

        return $result;
    }

    public static function getActivity($activity) {
        return [
            "guid" => $activity->id,
            "type" => $activity->action_type,
            "entity" => Filter::getEntity($activity->getObjectEntity())
        ];
    }

    public static function getEntities($entities) {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = Filter::getEntity($entity);
        }

        return $result;
    }

    public static function getEntity($entity) {
        $type = "{$entity->type}";

        if ($entity instanceof \ElggObject) {
            $type .= ":{$entity->getSubtype()}";
        }

        switch ($type) {
            case "user":
                $result = Filter::getUser($entity);
                break;
            case "group":
                $result = Filter::getGroup($entity);
                break;
            case "object:news":
                $result = Filter::getNews($entity);
                break;
            case "object:blog":
                $result = Filter::getBlog($entity);
                break;
            case "object:discussion":
                $result = Filter::getDiscussion($entity);
                break;
            case "object:event":
                $result = Filter::getEvent($entity);
                break;
            case "object:comment":
                $result = Filter::getComment($entity);
                break;
            default:
                $result = [];
        }

        $result["type"] = $type;
        return $result;
    }

    public static function getUser($entity) {
        return [
            "guid" => $entity->guid,
            "name" => $entity->name,
            "icon" => $entity->getIcon(),
            "profile" => []
        ];
    }

    public static function getGroup($entity) {
        return [
            "guid" => $entity->guid,
            "name" => $entity->name,
            "description" => $entity->description,
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created),
            "tags" => Helpers::formatTags($entity->tags)
        ];
    }

    public static function getNews($entity) {
        return [
            "guid" => $entity->guid,
            "title" => $entity->title,
            "description" => $entity->description,
            "summary" => elgg_get_excerpt($entity->description),
            "source" => $entity->source,
            "owner" => Filter::getUser($entity->getOwnerEntity()),
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created),
            "tags" => Helpers::formatTags($entity->tags)
        ];
    }

    public static function getBlog($entity) {
        return [
            "guid" => $entity->guid,
            "title" => $entity->title,
            "description" => $entity->description,
            "summary" => elgg_get_excerpt($entity->description),
            "owner" => Filter::getUser($entity->getOwnerEntity()),
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created),
            "tags" => Helpers::formatTags($entity->tags)
        ];
    }

    public static function getDiscussion($entity) {
        return [
            "guid" => $entity->guid,
            "title" => $entity->title,
            "description" => $entity->description,
            "summary" => elgg_get_excerpt($entity->description),
            "owner" => Filter::getUser($entity->getOwnerEntity()),
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created),
            "tags" => Helpers::formatTags($entity->tags)
        ];
    }

    public static function getEvent($entity) {
        return [
            "guid" => $entity->guid,
            "title" => $entity->title,
            "description" => $entity->description,
            "summary" => elgg_get_excerpt($entity->description),
            "owner" => Filter::getUser($entity->getOwnerEntity()),
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created),
            "tags" => Helpers::formatTags($entity->tags)
        ];
    }

    public static function getComment($entity) {
        return [
            "guid" => $entity->guid,
            "title" => $entity->title,
            "description" => $entity->description,
            "owner" => Filter::getUser($entity->getOwnerEntity()),
            "timeCreated" => \DateTime::createFromFormat('U', $entity->time_created),
            "timeUpdated" => \DateTime::createFromFormat('U', $entity->time_created)
        ];
    }
}



