<?php
/**
 * API for Billing
 *
 * @link      https://github.com/hiqdev/billing-hiapi
 * @package   billing-hiapi
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\billing\hiapi\plan;

use League\Tactician\Middleware;
use hiqdev\php\billing\plan\Plan;
use hiqdev\billing\hiapi\plan\PlanRepository;

class PlanLoader implements Middleware
{
    private $repo;

    public function __construct(PlanRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute($command, callable $next)
    {
        if (empty($command->plan)) {
            $command->plan = $this->findPlan($command);
        }

        return $next($command);
    }

    private function findPlan($command): ?Plan
    {
        if (empty($command->plan_id)) {
            return null;
        }

        return $this->repo->findById($command->plan_id);
    }
}
