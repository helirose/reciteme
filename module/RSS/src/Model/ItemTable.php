<?php

/**
 * Code for this class and many like it were adapted from the Laminas docs and examples to fit the required purpose
 */

namespace RSS\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ItemTable
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
    public function getItem($id)
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
    public function saveItem(Item $item)
    {
        $data = [
            'title' => $item->title,
            'link' => $item->link,
            'description' => $item->description,
            'language' => $item->language,
            'copyright' => $item->copyright,
            'managing_editor' => $item->managing_editor,
            'web_master' => $item->web_master,
            'pub_date' => $item->pub_date,
            'last_build_date' => $item->last_build_date,
            'generator' => $item->generator,
            'docs' => $item->docs,
            'cloud_id' => $item->cloud_id,
            'ttl' => $item->ttl,
            'image_id' => $item->image_id,
            'skip_hours' => $item->skip_hours,
            'skip_days' => $item->skip_days
        ];

        $this->tableGateway->insert($data);
        return;
    }
}