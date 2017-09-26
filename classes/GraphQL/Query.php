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
                    'resolve' => function() {
                        return DataProvider::getActivityList();
                    }
                ])
                ->addField('bookmarks', [
                    'type' => new Types\EntityList(),
                    'args' => [
                        'offset' => new IntType(),
                        'limit' => new IntType()
                    ],
                    'resolve' => function() {
                        return DataProvider::getBookmarkList();
                    }
                ])
                ->addField('entity', [
                    'type' => new Types\Entity(),
                    'args' => [
                        'guid' => new IdType()
                    ],
                    'resolve' => function() {
                        return DataProvider::getEntity();
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
                    'resolve' => function() {
                        return DataProvider::getEntityList();
                    }
                ])
                ->addField('groups', [
                    'type' => new Types\EntityList(),
                    'args' => [
                        'filter' => new Types\GroupFilterEnum(),
                        'offset' => new IntType(),
                        'limit' => new IntType()
                    ],
                    'resolve' => function() {
                        return DataProvider::getGroupList();
                    }
                ])
                ->addField('search', [
                    'type' => new Types\EntityList(),
                    'args' => [
                        'q' => new StringType(),
                        'entityType' => new Types\EntityEnum(),
                        'offset' => new IntType(),
                        'limit' => new IntType()
                    ],
                    'resolve' => function() {
                        return DataProvider::getSearchList();
                    }
                ]);
}
}