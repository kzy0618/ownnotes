<?php
namespace OCA\OwnNotes\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class NoteMapper extends Mapper {
	/**
	 *The first parent constructor parameter is the database connection object (or database handle), the second one is the database table and the third is the entity which the result should be mapped onto. Insert, delete and update methods are already implemented.
 */
    public function __construct(IDb $db) {
        parent::__construct($db, 'ownnotes_notes', '\OCA\OwnNotes\Db\Note');
    }

    public function find($id, $userId) {
        $sql = 'SELECT * FROM *PREFIX*ownnotes_notes WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll($userId) {
        $sql = 'SELECT * FROM *PREFIX*ownnotes_notes WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }

}

