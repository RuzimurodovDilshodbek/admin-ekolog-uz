<?php

namespace App\Http\Apis;

use Laragear\ApiManager\ApiServer;

class Chirper extends ApiServer
{
    /**
     * The headers to include in each request.
     *
     * @var array|array{string:string}
     */
    public array $headers = [
        // ...
    ];

    /**
     * The list of simple actions for this API.
     *
     * @var array|string[]
     */
    public array $actions = [
        'latest' => '/',
        'create' => 'post:new',
    ];

    /**
     * Returns the API base URL.
     *
     * @return string
     */
    abstract public function getBaseUrl(): string
    {
        return app()->isProduction()
            ? 'https://chirper.com/api/v1'
            : 'https://dev.chirper.com/api/v1';
    }

    /**
     * Returns the Bearer Token used for authentication.
     *
     * @return string
     */
    protected function authToken(): string
    {
        return config('services.chirper.secret');
    }

    public array $actions = [
        'chirp'  => 'post:/new',
        'edit'   => 'patch:/chirp/{chirp}',
        'delete' => 'delete:/chirp/{chirp}',
    ];

    public function onlyForFollowers(PendingRequest $request)
    {
        $request->withHeaders(['X-Followers-Only' => 'true']);

        return $this;
    }

    public function quoting(PendingRequest $request, $id)
    {
        $request->withHeaders(['X-Quote' => $id]);
     
        return $this;
    }
}
