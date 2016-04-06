<?php
$app->get('/', "twitter_clone.controller:indexAction");
$app->post('/tweet', "twitter_clone.controller:tweetAction");
