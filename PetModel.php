<?php
class Petmodel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM pets ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM pets WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReport($id, $data) {
        $sql = "UPDATE pets SET 
                durum = :durum, belirtiler = :belirtiler, tedavi = :tedavi, 
                rontgen = :rontgen, kan_tahlili = :kan_tahlili, 
                igne_serum = :igne_serum, recete = :recete 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
?>