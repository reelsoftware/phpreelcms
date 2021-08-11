<?php
namespace App\Helpers\PlansProcessor;

/**
 * IPaymentStrategy declares operations common to all subscription plans
 *
 * This is used inside PlanContext to call the appropriate strategy
 */
interface IPlanStrategy
{
    public function index();
    public function create();
    public function store();
    public function edit();
    public function update();
}