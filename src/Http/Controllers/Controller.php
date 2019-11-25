<?php

namespace LimeDeck\NovaCashierOverview\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Stripe\Stripe;

abstract class Controller extends BaseController
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Controller constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Http\Request                $request
     */
    public function __construct(Repository $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;

        $this->middleware(function ($request, $next) {
            Stripe::setApiKey($this->config->get('cashier.secret'));

            return $next($request);
        });
    }
}
