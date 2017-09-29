<?php
use Youshido\GraphQL\Execution\Processor;
use Youshido\GraphQL\Schema\Schema;
use GraphQL\Types;
use GraphQL\Query;
use GraphQL\Mutation;

$schema = new Schema([
	'query' => new Query(),
	'mutation' => new Mutation(),
    'types' => [
        new Types\User(),
        new Types\Group(),
        new Types\Blog(),
        new Types\News(),
        new Types\Discussion(),
        new Types\Event()
    ]
]);

$processor = new Processor($schema);

$input = json_decode(file_get_contents("php://input"), true);

$processor->processPayload($input["query"], $input["variables"]);

header('Content-Type: application/json');
echo json_encode($processor->getResponseData()) . PHP_EOL;
