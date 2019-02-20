<?php

namespace Holger\Entities;

class Host implements \JsonSerializable
{
    protected $ipAddress;
    protected $macAddress;
    protected $leaseTimeRemaining;
    protected $addressSource;
    protected $interfaceType;
    protected $active;
    protected $hostName;
    protected $guest = false;
    protected $speed;

    /**
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->guest;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $ipAddress
     *
     * @return Host
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @param mixed $macAddress
     *
     * @return Host
     */
    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;

        return $this;
    }

    /**
     * @param mixed $leaseTimeRemaining
     *
     * @return Host
     */
    public function setLeaseTimeRemaining($leaseTimeRemaining)
    {
        $this->leaseTimeRemaining = $leaseTimeRemaining;

        return $this;
    }

    /**
     * @param mixed $addressSource
     *
     * @return Host
     */
    public function setAddressSource($addressSource)
    {
        $this->addressSource = $addressSource;

        return $this;
    }

    /**
     * @param mixed $interfaceType
     *
     * @return Host
     */
    public function setInterfaceType($interfaceType)
    {
        $this->interfaceType = $interfaceType;

        return $this;
    }

    /**
     * @param bool $active
     *
     * @return Host
     */
    public function setActive(bool $active): Host
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param mixed $hostName
     *
     * @return Host
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }

    /**
     * @param bool $guest
     *
     * @return Host
     */
    public function setGuest(bool $guest): Host
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * @param mixed $speed
     *
     * @return Host
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    public function __construct(
        $ipAddress, $macAddress, $leaseTimeRemaining, $addressSource, $interfaceType, $active, $hostName
    ) {
        $this->ipAddress = $ipAddress;
        $this->macAddress = $macAddress;
        $this->leaseTimeRemaining = $leaseTimeRemaining;
        $this->addressSource = $addressSource;
        $this->interfaceType = $interfaceType;
        $this->active = boolval($active);
        $this->hostName = $hostName;
    }

    /**
     * Creates a new instance of Host from an API response.
     *
     * @param array $apiResponse
     *
     * @return Host
     */
    public static function fromResponse(array $apiResponse)
    {
        return new static(
            $apiResponse['NewIPAddress'],
            $apiResponse['NewMACAddress'],
            $apiResponse['NewLeaseTimeRemaining'],
            $apiResponse['NewAddressSource'],
            $apiResponse['NewInterfaceType'],
            $apiResponse['NewActive'],
            $apiResponse['NewHostName']
        );
    }

    /**
     * Return the associated IP address
     * Depending on your network config this can be an IPv4 or IPv6 address.
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Return the hardware MAC address.
     *
     * @return string
     */
    public function getMacAddress()
    {
        return $this->macAddress;
    }

    /**
     * Returns the time until there will be a new lease for this device.
     *
     * @return string
     */
    public function getLeaseTimeRemaining()
    {
        return $this->leaseTimeRemaining;
    }

    /**
     * Returns how the address was assigned
     * Possible values:
     *  - DHCP: DHCP assignment.
     *
     * @return string
     */
    public function getAddressSource()
    {
        return $this->addressSource;
    }

    /**
     * Gives the type of the connection (WiFi, Ethernet...)
     * Possible values:
     *  - 802.11 for WiFi.
     *
     * @return string
     */
    public function getInterfaceType()
    {
        return $this->interfaceType;
    }

    /**
     * True if the host is currently active.
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Returns the hostname that is assigned to this device.
     *
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
