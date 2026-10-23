<?php
class Subscription
{
    private int $id;
    private string $service_name;
    private float $monthly_cost;
    private int $billing_day;
    private string $status;


    function __toString()
    {
        return "<br>$this->id, $this->service_name, $this->monthly_cost, $this->billing_day,$this->status";
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function getService_name()
    {
        return $this->service_name;
    }


    public function setService_name($service_name)
    {
        $this->service_name = $service_name;

        return $this;
    }


    public function getMonthly_cost()
    {
        return $this->monthly_cost;
    }


    public function setMonthly_cost($monthly_cost)
    {
        $this->monthly_cost = $monthly_cost;

        return $this;
    }


    public function getBilling_day()
    {
        return $this->billing_day;
    }


    public function setBilling_day($billing_day)
    {
        $this->billing_day = $billing_day;

        return $this;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
