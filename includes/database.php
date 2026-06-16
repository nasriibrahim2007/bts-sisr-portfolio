<?php
/**
 * Gestion de la base de données (JSON)
 */

class Database {
    private $filePath;
    private $data;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        $this->load();
    }

    /**
     * Charge les données depuis le fichier JSON
     */
    private function load() {
        if (file_exists($this->filePath)) {
            $json = file_get_contents($this->filePath);
            $this->data = json_decode($json, true);
        } else {
            $this->data = $this->getDefaultData();
            $this->save();
        }
    }

    /**
     * Sauvegarde les données dans le fichier JSON
     */
    public function save() {
        $json = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->filePath, $json);
    }

    /**
     * Obtient la structure de données par défaut
     */
    private function getDefaultData() {
        return [
            'profile' => [
                'name' => 'Votre Nom',
                'title' => 'Étudiant BTS SIO SISR',
                'email' => 'votre.email@example.com',
                'phone' => '+33 6 XX XX XX XX',
                'linkedin' => 'https://linkedin.com/in/votre-profile',
                'github' => 'https://github.com/votreusername',
                'description' => 'Étudiant en première année de BTS Services Informatiques aux Organisations, spécialité Solutions d\'Infrastructure, Systèmes et Réseaux.',
                'avatar' => 'default-avatar.jpg'
            ],
            'skills' => [],
            'stages' => [],
            'projects' => [],
            'menu' => [
                'home' => true,
                'skills' => true,
                'stages' => true,
                'projects' => true,
                'contact' => true
            ]
        ];
    }

    /**
     * Obtient toutes les données
     */
    public function getAll() {
        return $this->data;
    }

    /**
     * Obtient une section
     */
    public function get($section, $id = null) {
        if ($id === null) {
            return $this->data[$section] ?? [];
        }
        
        $items = $this->data[$section] ?? [];
        foreach ($items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Ajoute un élément
     */
    public function add($section, $item) {
        $item['id'] = uniqid();
        $item['created_at'] = date('Y-m-d H:i:s');
        $this->data[$section][] = $item;
        $this->save();
        return $item;
    }

    /**
     * Met à jour un élément
     */
    public function update($section, $id, $item) {
        $items = &$this->data[$section];
        foreach ($items as &$currentItem) {
            if ($currentItem['id'] === $id) {
                $item['updated_at'] = date('Y-m-d H:i:s');
                $currentItem = array_merge($currentItem, $item);
                $this->save();
                return $currentItem;
            }
        }
        return null;
    }

    /**
     * Supprime un élément
     */
    public function delete($section, $id) {
        $items = &$this->data[$section];
        foreach ($items as $key => $item) {
            if ($item['id'] === $id) {
                unset($items[$key]);
                $items = array_values($items); // Réindexe le tableau
                $this->save();
                return true;
            }
        }
        return false;
    }

    /**
     * Met à jour le profil
     */
    public function updateProfile($profileData) {
        $this->data['profile'] = array_merge($this->data['profile'], $profileData);
        $this->save();
        return $this->data['profile'];
    }

    /**
     * Obtient le profil
     */
    public function getProfile() {
        return $this->data['profile'] ?? [];
    }
}

// Initialisation globale de la DB
$db = new Database(DB_FILE);

?>
