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
                "guid" => $user->guid,
                "email" => $user->email,
                "name" => $user->name,
                "icon" => $user->getIconURL(),
                "url" => $user->getURL(),
                "profile" => []
            ]
        ];
    }

    public static function getActivityList() {
        return [
            "total" => 0,
            "edges" => []
        ];
    }

    public static function getBookmarkList() {
        return [
            "total" => 0,
            "edges" => []
        ];
    }

    public static function getEntity() {
        return [
            "guid" => 0
        ];
    }

    public static function getEntityList() {
        return [
            "total" => 0,
            "edges" => []
        ];
    }

    public static function getGroupList() {
        return [
            "total" => 0,
            "edges" => []
        ];
    }

    public static function getSearchList() {
        return [
            "total" => 0,
            "edges" => []
        ];
    }
}