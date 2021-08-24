<?php

namespace RSS\Controller;

use RSS\Model\Channel;
use RSS\Model\ChannelTable;
use RSS\Form\ChannelForm;
use Laminas\Feed\Reader\Reader;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ChannelController extends AbstractActionController
{
    private $table;

    // Makes controller dependent on RSS table
    public function __construct(ChannelTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'feeds' => $this->table->fetchAll(),
        ]);
    }

    /**
     * Save an RSS feed to the database
     * Ideally, logic for fetching and processing the XML 
     * data would be extracted to it's own class according 
     * to SOLID principles (single responsibility)
     *
     * @return redirect
     */
    public function addAction()
    {
        $form = new ChannelForm();
        $form->get('submit')->setValue('Add');

        /** @var \Laminas\Http\Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $channel = new Channel();
        $form->setInputFilter($channel->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $channel->exchangeArray($form->getData());

        var_dump($channel);

        // Validate and retrieve xml File
        $this->table->saveChannel($channel);

        return $this->redirect()->toRoute('rss');
    }
}