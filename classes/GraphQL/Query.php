<?php
namespace GraphQL;

use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;

class Query extends AbstractObjectType {
    public function getName() {
        return 'Query';
    }

    public function build($config) {
        $config->addField('site', [
            'type' => new Types\Site(),
            'resolve' => function() {
                return DataProvider::getSite();
            }
        ])
        ->addField('viewer', [
            'type' => new Types\Viewer(),
            'resolve' => function() {
                return DataProvider::getViewer();
            }
        ])
        ->addField('activities', [
            'type' => new Types\ActivityList(),
            'args' => [
                'groupGuid' => new IdType(),
                'offset' => new IntType(),
                'limit' => new IntType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getActivityList($source, $args);
            }
        ])
        ->addField('bookmarks', [
            'type' => new Types\EntityList(),
            'args' => [
                'offset' => new IntType(),
                'limit' => new IntType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getBookmarkList($source, $args);
            }
        ])
        ->addField('entity', [
            'type' => new Types\Entity(),
            'args' => [
                'guid' => new IdType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getEntity($source, $args);
            }
        ])
        ->addField('entities', [
            'type' => new Types\EntityList(),
            'args' => [
                'groupGuid' => new IdType(),
                'entityType' => new Types\EntityEnum(),
                'offset' => new IntType(),
                'limit' => new IntType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getEntityList($source, $args);
            }
        ])
        ->addField('groups', [
            'type' => new Types\EntityList(),
            'args' => [
                'filter' => new Types\GroupFilterEnum(),
                'offset' => new IntType(),
                'limit' => new IntType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getGroupList($source, $args);
            }
        ])
        ->addField('search', [
            'type' => new Types\EntityList(),
            'args' => [
                'q' => new StringType(),
                'groupGuid' => new IdType(),
                'entityType' => new Types\EntityEnum(),
                'offset' => new IntType(),
                'limit' => new IntType()
            ],
            'resolve' => function($source, $args, $resolveInfo) {
                return DataProvider::getSearchList($source, $args);
            }
        ]);
    }
}