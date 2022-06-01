<?php

namespace App\Contracts;

interface ShipmentsInterface
{
    public function createShipment($order, $branch);

    public function createPickUp($orders);

    public function getDeliveryFees($address, $cart);

    public function checkShipmentStatus($shipmentId);

    public function cancelPickup($pickup);
}