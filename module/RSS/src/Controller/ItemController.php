<?php

namespace RSS\Controller;

use RSS\Model\Item;
use RSS\Model\ItemTable;
use RSS\Form\ChannelForm;
use Laminas\Feed\Reader\Reader;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    private $table;

    // Makes controller dependent on RSS table
    public function __construct(ItemTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'item' => $this->table->fetchAll(),
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

        $rss = new Item();
        $form->setInputFilter($rss->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $rss->exchangeArray($form->getData());

        // Validate and retrieve xml File
        try {

            // Read xml file into array and check for errors
            $reader = new Reader;

            $xml = $reader->import($rss->link);

            // Initialize the channel/feed data array
            $channel = [
                'title'       => $xml->getTitle(),
                'link'        => $xml->getLink(),
                'description' => $xml->getDescription(),
                'language'    => $xml->getLanguage(),
                'copyright'   => $xml->getCopyright(),
                'items'       => [],
            ];

            // Loop over each channel item/entry and store relevant data for each
            foreach ($xml as $item) {
                $channel['items'][] = [
                    'title'       => $item->getTitle(),
                    'link'        => $item->getLink(),
                    'description' => $item->getDescription(),
                ];
            }

            $rss->title = isset($channel['title']) ? $channel['title'] : '';
            $rss->link = isset($channel['link']) ? $channel['link'] : '';
            $rss->description = isset($channel['description']) ? $channel['description'] : '';
            $rss->language = isset($channel['language']) ? $channel['language'] : '';
            $rss->copyright = isset($channel['copyright']) ? $channel['copyright'] : '';

            $now = (new \DateTime())->format('Y-m-d H:i:s');

            $hours = [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0,
                '13' => 0,
                '14' => 0,
                '15' => 0,
                '16' => 0,
                '17' => 0,
                '18' => 0,
                '19' => 0,
                '20' => 0,
                '21' => 0,
                '22' => 0,
                '23' => 0,
                '24' => 0,
            ];

            $days = [
                'monday' => 0,
                'tuesday' => 0,
                'wednesday' => 0,
                'thursday' => 0,
                'friday' => 0,
                'saturday' => 0,
                'sunday' => 0,
            ];

            // Process XML
            // $rss->title = isset($xml['title']) ? $xml['title'] : '';
            // $rss->link = isset($xml['link']) ? $xml['link'] : '';
            // $rss->description = isset($xml['description']) ? $xml['description'] : '';
            // $rss->language = isset($xml['language']) ? $xml['language'] : '';
            // $rss->copyright = isset($xml['copyright']) ? $xml['copyright'] : '';
            // $rss->managing_editor = isset($xml['managingEditor']) ? $xml['managingEditor'] : '';
            // $rss->web_master = isset($xml['webMaster']) ? $xml['webMaster'] : '';
            // $rss->pub_date = isset($xml['pubDate']) ? $xml['pubDate'] : $now;
            // $rss->last_build_date = isset($xml['lastBuildDate']) ? $xml['lastBuildDate'] : $now;
            // $rss->generator = isset($xml['generator']) ? $xml['generator'] : '';
            // $rss->docs = isset($xml['docs']) ? $xml['docs'] : '';
            // $rss->ttl = isset($xml['ttl']) ? $xml['ttl'] : 0;

            $this->table->saveItem($rss);
        } catch(\Exception $e) {
            echo $e->getMessage();
        }

        return $this->redirect()->toRoute('rss');
    }
}