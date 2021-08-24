<?php

/**
 * Code for this class and many like it were adapted from the Laminas docs and examples to fit the required purpose
 */

namespace RSS\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ChannelTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    // Fetches all entries
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    // Gets individual entry by id or throws error if not found
    public function getChannel($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    // Saves entry to the database or updates if valid id is provided
    public function saveChannel(Channel $channel)
    {
        $data = [
            'name' => $channel->name,
            'url' => $channel->url
        ];

        $this->tableGateway->insert($data);
        
        return;
    }
}