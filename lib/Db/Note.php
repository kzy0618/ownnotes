<?php
namespace OCA\OwnNotes\Db;

use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Note extends Entity implements JsonSerializable {

    protected $title;
    protected $content;
    protected $userId;

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }

}
