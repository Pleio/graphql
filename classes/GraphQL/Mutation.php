<?php
namespace GraphQL;

use Youshido\GraphQL\Type\Object\AbstractObjectType;

class Mutation extends AbstractObjectType {
    public function getName() {
        return 'Mutation';
    }

    public function build($config) {

    }
}