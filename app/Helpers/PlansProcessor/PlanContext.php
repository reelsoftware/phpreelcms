<?php
namespace App\Helpers\PlansProcessor; 

/**
 * The Context defines the interface for plans
 */
class PlanContext
{
    /**
     * @var IPlanStrategy Reference to one concrete PlanStrategy that 
     * implements the plan itself
     */
    private $planStrategy;

    /**
     * Replace the strategy at runtime depending on what payment processing company is used
     */
    public function setPlanStrategy(IPlanStrategy $strategy)
    {
        $this->planStrategy = $strategy;
    }

    /**
     * Show all the plans
     */
    public function index()
    {
        return $this->planStrategy->index();
    }

    /**
     * Create the plan
     */
    public function create()
    {
        return $this->planStrategy->create();
    }

    /**
     * Store the plan
     */
    public function store()
    {
        return $this->planStrategy->store();
    }

    /**
     * Edit the plan
     */
    public function edit()
    {
        return $this->planStrategy->edit();
    }

    /**
     * Update the plan
     */
    public function update()
    {
        return $this->planStrategy->update();
    }
}