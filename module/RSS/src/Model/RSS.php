<?php

namespace RSS\Model;

class RSS
{
    public $id;
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
}