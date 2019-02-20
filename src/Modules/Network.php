<?php

namespace Holger\Modules;

use Holger\Entities\Host;
use Holger\HasEndpoint;

class Network
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/hosts',
        'uri' => 'urn:dslforum-org:service:Hosts:1',
        'scpdurl' => '/hostsSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * Fetches the number of known hosts
     * These are the members of the network that have been registered some time.
     *
     * @return int
     */
    public function numberOfHostEntries()
    {
        return (int)$this->prepareRequest()->GetHostNumberOfEntries();
    }

    /**
     * Get information about one peer in the local network.
     * Data includes the IP address (NewIPAddress), MAC Address (NewMACAddress)
     * and much more.
     *
     * @param $id
     *
     * @return Host
     */
    public function hostById($id)
    {
        $idParam = new \SoapParam($id, 'NewIndex');
        try {
            $response = $this->prepareRequest()->GetGenericHostEntry($idParam);
        } catch (\SoapFault $e) {
            return null;
        }

        return Host::fromResponse($response);
    }

    /**
     * Get information like IP address of a host given by the mac address.
     *
     * @param $mac
     *
     * @return Host
     */
    public function hostByMAC($mac)
    {
        $macParam = new \SoapParam($mac, 'NewMACAddress');

        $response = $this->prepareRequest()->GetSpecificHostEntry($macParam);
        $response['NewMACAddress'] = $mac;

        return Host::fromResponse($response);
    }

    /**
     * @return string
     */
    public function getHostListUrl()
    {
        $url = $this->prepareRequest()->__call('X_AVM-DE_GetHostListPath', []);

        return $this->conn->makeUri($url);
    }

    /**
     * @return array
     */
    public function getHostList()
    {
        $data = simplexml_load_file($this->getHostListUrl());

        $hosts = [];

        foreach ($data as $item) {
            $host = $this->hostById((string) $item->Index - 1);
            if (!$host) {
                continue;
            }
            $host->setInterfaceType((string) $item->InterfaceType);
            $host->setSpeed((int) $item->{'X_AVM-DE_Speed'});
            $host->setGuest((string) $item->{'X_AVM-DE_Guest'});
            $hosts[] = $host;
        }

        return $hosts;
    }
}
