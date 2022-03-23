<?php

$router->get('/', fn () => 'this is the homepage');

$router->post('/post-route', fn () => 'post content');

$router->get('/html',
    fn () => '<html><body><div>div content</div></body></html>'
);

$router->get('/json',
    fn () => response()->json([
        'first' => 'value1',
        'second' => 'value2',
    ])
);


