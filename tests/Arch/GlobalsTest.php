<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| HTTP context helpers
|--------------------------------------------------------------------------
|
| session()/auth()/request() implicitly read the current HTTP request.
| Confining them to App\Http keeps Actions, Support classes and commands
| callable from any context, not only from behind a web request.
|
*/

arch('http context helpers stay in the http layer')
    ->expect(['session', 'auth', 'request'])
    ->toOnlyBeUsedIn('App\Http');
