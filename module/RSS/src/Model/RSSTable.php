<?php

/**
 * Code for this class and many like it were adapted from the Laminas docs and examples to fit the required purpose
 */

namespace RSS\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class RSSTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    // Fetches all entries
    public function fetchAll()
    {
        try {
            return $this->tableGateway->select();
        } catch(\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    // Gets individual entry by id or throws error if not found
    public function getRSS($id)
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
    public function saveRSS(RSS $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int) $album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getRSS($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update RSS with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteRSS($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}