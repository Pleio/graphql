<?php

function graphql_init() {
    elgg_register_page_handler("graphql", "graphql_page_handler");
}

function graphql_page_handler($page) {
    include("pages/graphql.php");
}