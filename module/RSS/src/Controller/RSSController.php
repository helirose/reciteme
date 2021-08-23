<?php

namespace RSS\Controller;

use RSS\Model\RSSTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class RSSController extends AbstractActionController
{
    private $table;

    // Makes controller dependent on RSS table
    public function __construct(RSSTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'feeds' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
    }
}