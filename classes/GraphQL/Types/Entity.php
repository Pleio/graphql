<?php
namespace GraphQL\Types;

use Youshido\GraphQL\Type\InterfaceType\AbstractInterfaceType;
use Youshido\GraphQL\Type\Scalar\IdType;

class Entity extends AbstractInterfaceType
{
    public function build($config) {
        $config->addFields([
            'guid' => new IdType()
        ]);
    }

    public function resolveType($entity) {
        switch ($entity["type"]) {
            case "user":
                return new User();
            case "group":
                return new Group();
            case "object:bookmark":
                return new Bookmark();
            case "object:comment":
                return new Comment();
            case "object:news":
                return new News();
            case "object:blog":
                return new Blog();
            case "object:discussion":
                return new Discussion();
            case "object:event":
                return new Event();
            default:
                throw new Exception("Trying to resolve an unknown type.");
        }
    }
}