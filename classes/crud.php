<?php

class Crud extends PDO
{
    public function __construct()
    {
        $envFile = dirname(__DIR__) . '/.env';
        $env = [];

        if (file_exists($envFile)) {
            $env = parse_ini_file($envFile);
        }

        $host = $env['DB_HOST'] ?? getenv('DB_HOST');
        $port = $env['DB_PORT'] ?? getenv('DB_PORT');
        $dbname = $env['DB_NAME'] ?? getenv('DB_NAME');
        $user = $env['DB_USER'] ?? getenv('DB_USER');
        $password = $env['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        parent::__construct(
            $dsn,
            $user,
            $password
        );

        $this->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
    }

    public function select(
        string $table,
        string $field = 'id',
        string $order = 'ASC'
    ): array {
        $order = strtoupper($order);

        if (!in_array($order, ['ASC', 'DESC'], true)) {
            $order = 'ASC';
        }

        $sql = "SELECT * FROM $table
                ORDER BY $field $order";

        return $this->query($sql)->fetchAll();
    }

    public function selectId(
        string $table,
        int|string $value,
        string $field = 'id'
    ): bool|array {
        $sql = "SELECT * FROM $table
                WHERE $field = :$field";

        $stmt = $this->prepare($sql);

        $stmt->bindValue(
            ":$field",
            $value
        );

        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            return $stmt->fetch();
        }

        return false;
    }

    public function insert(
        string $table,
        array $data
    ): bool|int {
        $fields = implode(
            ', ',
            array_keys($data)
        );

        $binds = ':' . implode(
            ', :',
            array_keys($data)
        );

        $sql = "INSERT INTO $table ($fields)
                VALUES ($binds)";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(
                ":$key",
                $value
            );
        }

        if ($stmt->execute()) {
            return (int) $this->lastInsertId();
        }

        return false;
    }

    public function update(
        string $table,
        array $data,
        string $field = 'id'
    ): bool {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }

        $fields = rtrim(
            $fields,
            ', '
        );

        $sql = "UPDATE $table
                SET $fields
                WHERE $field = :$field";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(
                ":$key",
                $value
            );
        }

        return $stmt->execute();
    }

    public function delete(
        string $table,
        int|string $value,
        string $field = 'id'
    ): bool {
        $sql = "DELETE FROM $table
                WHERE $field = :$field";

        $stmt = $this->prepare($sql);

        $stmt->bindValue(
            ":$field",
            $value
        );

        return $stmt->execute();
    }
}