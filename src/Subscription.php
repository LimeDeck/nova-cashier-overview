<?php

namespace LimeDeck\NovaCashierOverview;

use Laravel\Nova\ResourceTool;

class Subscription extends ResourceTool
{
    /**
     * Subscription constructor.
     *
     * @param string $subscription
     */
    public function __construct(string $subscription = 'default')
    {
        parent::__construct();

        $this->withMeta(compact('subscription'));
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Subscription';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'subscription';
    }
}
