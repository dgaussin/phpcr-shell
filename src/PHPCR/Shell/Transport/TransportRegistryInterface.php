<?php

namespace PHPCR\Shell\Transport;

/**
 * Interface for transport factory
 *
 * Note that transport registry is a bit of a misnomer - 
 * logically it would be RepositoryFactoryInitializerInterface,
 * which is too long imo.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface TransportRegistryInterface
{
    /**
     * Return all of the registered transport names
     *
     * @return array
     */
    public function getTransportNames();

    /**
     * Return the transport with the given name
     *
     * @param string $name
     *
     * @return PHPCR\Shell\Transport\Transport\TransportInterface
     */
    public function getTransport($name);
}
