<?php

namespace RSS\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Item implements InputFilterAwareInterface
{
    public $id;
    public $channel_id;
    public $channel;
    public $title;
    public $link;
    public $description;
    public $language;
    public $copyright;
    public $managing_editor;
    public $web_master;
    public $pub_date;
    public $last_build_date;
    public $generator;
    public $docs;
    public $cloud_id;
    public $ttl;
    public $image_id;
    public $skip_hours;
    public $skip_days;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->link = !empty($data['link']) ? $data['link'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
        $this->language = !empty($data['language']) ? $data['language'] : null;
        $this->copyright = !empty($data['copyright']) ? $data['copyright'] : null;
        $this->managing_editor = !empty($data['managing_editor']) ? $data['managing_editor'] : null;
        $this->web_master = !empty($data['web_master']) ? $data['web_master'] : null;
        $this->pub_date = !empty($data['pub_date']) ? $data['pub_date'] : null;
        $this->last_build_date = !empty($data['last_build_date']) ? $data['last_build_date'] : null;
        $this->generator = !empty($data['generator']) ? $data['generator'] : null;
        $this->docs = !empty($data['docs']) ? $data['docs'] : null;
        $this->cloud_id = !empty($data['cloud_id']) ? $data['cloud_id'] : null;
        $this->ttl = !empty($data['ttl']) ? $data['ttl'] : null;
        $this->image_id = !empty($data['image_id']) ? $data['image_id'] : null;
        $this->skip_hours = !empty($data['skip_hours']) ? $data['skip_hours'] : null;
        $this->skip_days = !empty($data['skip_days']) ? $data['skip_days'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'link',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}