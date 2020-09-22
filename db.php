<?php

class DB {
    protected $host = 'localhost';
    protected $db   = 'project_manager';
    protected $user = 'root';
    protected $pass = 'root';
    protected $charset = 'utf8mb4';
    protected $dsn;
    protected $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    }

    public function getPDO()
    {
        return new PDO($this->dsn, $this->user, $this->pass, $this->options);
    }

    public function countProjects($status = null)
    {
        if ($status) {
            $stmt = $this->getPDO()
                ->prepare("
                    SELECT count(*) as count 
                    FROM projects
                    WHERE status=:status
                ");
            $stmt->execute(['status' => $status]);

            return $stmt->fetch()['count'];
        }

        return $this->getPDO()
            ->query("
                SELECT count(*) as count from projects
            ")->fetch()['count'];
    }

    public function getProjects($limit = 10, $offset = 0, $status)
    {
        if ($status) {
            $stmt = $this->getPDO()->prepare("
                SELECT * 
                FROM projects 
                WHERE status=:status
                LIMIT :limit
                OFFSET :offset
            ");

            $stmt->execute([
                'offset' => $offset,
                'limit' => $limit,
                'status' => $status,
            ]);
        }
        else {
            $stmt = $this->getPDO()->prepare("
                SELECT * 
                FROM projects 
                WHERE 1
                LIMIT :limit
                OFFSET :offset
            ");

            $stmt->execute([
                'offset' => $offset,
                'limit' => $limit,
            ]);
        }

        return $stmt->fetchAll();
    }

    public function createProject($data)
    {
        $this->getPDO()
            ->prepare("
                INSERT INTO projects(name, description, status) 
                VALUES (:name, :description, :status)"
            )
            ->execute($data);
    }

    public function updateProject($data)
    {
        $this->getPDO()
            ->prepare("
                UPDATE projects 
                SET name=:name, description=:description, status=:status
                WHERE projects.ID=:ID
            ")
            ->execute([
                'ID' => $data['ID'],
                'name' => $data['name'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);
    }

    public function getProjectById($id)
    {
        $stmt = $this->getPDO()->query('SELECT * from projects where id='.$id);

        return $stmt->fetch();
    }

    public function deleteProjectById($id)
    {
        $this->getPDO()
            ->prepare('DELETE FROM projects where ID=:ID')
            ->execute(['ID'=> $id]);
    }

    public function countContactsByProjectId($id)
    {
        $stmt = $this->getPDO()
            ->prepare("
                SELECT count(*) as count 
                FROM contacts
                WHERE project_id=:id
            ");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch()['count'];
    }

    public function getContactsForProject($id)
    {
        $stmt = $this->getPDO()
            ->prepare("
                SELECT *
                FROM contacts
                WHERE project_id=:id
            ");
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll();
    }

    public function updateContacts($id, $contacts)
    {
        $stmt = $this->getPDO()
            ->prepare("
                DELETE FROM contacts WHERE project_id=:id
            ");
        $stmt->execute(['id' => $id]);

        foreach($contacts as $contact) {
            if (isset($contact['email']) && !empty($contact['email']) && isset($contact['name']) && !empty($contact['email'])) {
                $this->getPDO()
                    ->prepare("
                        INSERT INTO contacts (name, email, project_id)
                        VALUES (:name, :email, :id)
                    ")->execute([
                        'name' => $contact['name'],
                        'email' => $contact['email'],
                        'id' => $id,
                    ]);
            }
        }
    }
}
