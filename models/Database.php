<?php

class Database {

    private $db;

    public function __construct() {
        $this->db = Db::getConnection();
    }

    public function addLessonInfo($groupNumber, $type, $length, $subject) {
        $query = $this->db->prepare("INSERT INTO `groups` (group_number, type, length, subject) VALUES ('$groupNumber', '$type', '$length', '$subject')");
        return $query->execute();
    }

    public function addProfessorInfo($professor, $subject) {
        $query = $this->db->prepare("INSERT INTO `professors` (professor, subject) VALUES('$professor', '$subject')");
        return $query->execute();
    }

    public function resetAll() {
        $query = $this->db->prepare("DELETE FROM `groups` WHERE id > 0");
        $a = $query->execute();

        $query = $this->db->prepare("DELETE FROM `professors` WHERE id > 0");
        $b = $query->execute();

        return $a && $b;
    }
}
