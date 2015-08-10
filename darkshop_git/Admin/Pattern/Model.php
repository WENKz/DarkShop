<?php

class Model {

    protected $db;
    protected $dbname = "DarkShop";
    protected $login = "Login";
    protected $pass = "Password";

    public function __construct() {
        $this->db = $this->connectDB();
    }

    public function connectDB() {
        $db = new PDO('mysql:host=localhost;dbname=' . $this->dbname, $this->login, $this->pass);
        $db->exec("set names utf8");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public function select($table, $data, $clauses = null, $order = false, $limit = false, $rowCount = false) {
        $build = "";
        $i = 0;
        // Champs sélectionnés
        foreach ($data as $value) {
            ($i == 0) ? $build = $value : $build .= ", " . $value;
            $i++;
        }
        // Table sélectionnée
        $build = "SELECT " . $build . " FROM " . $table . " ";
        // Clause WHERE et AND
        if ($clauses) {
            $i = 1;
            $like = 0;
            foreach ($clauses as $column => $value) {
                // Différencier = et LIKE
                if (!is_array($value)) {
                    $lastChar = strlen($value) - 1;
                    if ($value[0] == "%" || $value[$lastChar] == "%") {
                        $ope = " LIKE ";
                        $like++;
                    }
                    // Opérateurs arithmétiques
                    else if ($value[0] == ">" || $value[0] == "<" || $value[0] == "<=" || $value[0] == ">=") {
                        $ope = $value[0];
                    } else {
                        $ope = " = ";
                    }
                }
                // On vérifie si c'est une recherche via LIKE
                ($like >= 2) ? $clause = "OR" : $clause = "AND";
                // Différencier WHERE et AND/OR
                ($i == 1) ? $build.= "WHERE " : $build.= " " . $clause . " ";
                // Clause IN
                if (is_array($value)) {
                    $ope = " IN (";
                    $f = 1;
                    foreach ($value as $element) {
                        if ($f == 1) {
                            $build .= $column . $ope . "'" . $element . "'";
                        } else {
                            $build .= ", '" . $element . "'";
                        }
                        $f++;
                    }
                    $build .= ") ";
                } else {
                    $build.= $column . $ope . "'" . $value . "'";
                }
                // Trier les résultats
                if (is_array($order)) {
                    $build.=" ORDER BY " . $order[0];
                    if (isset($order[1])) {
                        $build.=" " . $order[1];
                    }
                }
                // Limiter les résultats
                if (is_array($limit)) {
                    $build.=" LIMIT " . $limit[0];
                    if (isset($limit[1])) {
                        $build.=", " . $limit[1];
                    }
                }
                $i++;
            }
        }
//        var_dump($build);
        $query = $this->db->prepare($build);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        // Renvoyer le nombre de lignes
        if ($rowCount) {
            return $query->rowCount();
        }
        return $result;
    }

    public function count($table, $count, $clauses = null) {
        $i = 0;
        // Table sélectionnée
        $build = "SELECT " . $count . ", COUNT(" . $count . ") AS nombre FROM " . $table . " ";
        // Clause WHERE et AND
        if ($clauses) {
            $i = 1;
            foreach ($clauses as $column => $value) {
                ($i == 1) ? $build.= "WHERE " : $build.= " AND ";
                $build.= $column . " = '" . addslashes($value) . "'";
                $i++;
            }
        }
//        var_dump($build);
        try {
            $query = $this->db->prepare($build);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function join($tables, $data, $clause = null, $where = null, $order = null, $limit = null) {
        $build = "";
        $i = 0;
        // Sélection de la table et des champs
        foreach ($data as $value) {
            ($i == 0) ? $build .= $value : $build .= ", " . $value;
            $i++;
        }
        // Table et champs sélectionnés
        $build = "SELECT DISTINCT " . $build . " FROM " . $tables[0][0];
        // Gestion de jointures multiples
        foreach ($tables as $table) {

            $build .= " INNER JOIN " . $table[1] . " ON " . $table[1] . "." . $table[2] . " = " . $table[0] . "." . $table[2];
            $i++;
        }
        if ($where) {
            $i = 1;
            foreach ($where as $column => $value) {
                ($i == 1) ? $build.= " WHERE " : $build.= " AND ";
                $build.= $column . " = '" . $value . "'";
                $i++;
            }
        }
        // Filtre supplémentaire
        if ($clause) {
            // Grouper les résultats
            $build.= " GROUP BY " . $clause[0];
            // Clause HAVING si 2ème paramètre spécifié
            if (isset($clause[1])) {
                $build.= " HAVING " . $clause[0] . " = " . $clause[1];
            }
        }
        // Tri ORDER BY
        if (is_array($order)) {
            $build.= " ORDER BY " . $order[0] . " " . $order[1];
        }
        // Limiter les résultats, Démarrer les résultats à partir d'un ID
        if (is_array($limit)) {
            $build.=" LIMIT " . $limit[0];
            if (isset($limit[1])) {
                $build.=", " . $limit[1];
            }
        }

//        var_dump($build);
        $query = $this->db->prepare($build);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($table, $values, $id_auto = false, $insert_id = false) {
        $db = $this->connectDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $array = array();

        // Formatage de la requête
        $query = "INSERT INTO " . $table . " VALUES(";
        $limit = count($values);
        $i = 1;
        if ($id_auto) {
            $query.= "'', ";
        }
        foreach ($values as $key => $value) {
            ($i < $limit) ? $query.= ":" . $key . ", " : $query .= ":" . $key;
            $i++;
        }
        $query.=")";
        try {
            
            $query = $this->db->prepare($query);
            foreach ($values as $key => $value) {
              $query->bindParam(":$key",$value);  
                
            }
//          
//              var_dump($query);
            $query->execute($values);
            return ($insert_id) ? $this->db->lastInsertId() : true;
        } catch (Exception $e) {
            echo "<div class='error'>" . $e->getMessage() . "</div>";
            exit();
        }
    }

    public function update($table, $data, $clauses = null, $rowCount = false) {
        // Formatage de la requête
        $build = "UPDATE " . $table . " SET ";
        $limit = count($data);
//        var_dump($data);
        $i = 1;
        foreach ($data as $key => $value) {
            ($i < $limit) ? $build.= $key . " = :" . $key . ", " : $build .= $key . " = :" . $key . " ";
            $i++;
        }
        // Clause WHERE et AND
        if ($clauses) {
            $i = 1;
            foreach ($clauses as $column => $value) {
                ($i == 1) ? $build.= "WHERE " : $build.= " AND ";
                $build.= $column . " = :" . $column . "";
                $i++;
            }
        }
        try {
            $query = $this->db->prepare($build);
//            var_dump($query);
//            exit();
            foreach ($clauses as $key => $clause) {
                $data[$key] = $clause;
            }
            $query->execute($data);
            if ($rowCount) {
                return $query->rowCount();
            }
        } catch (Exception $e) {
            echo "<div class='error'>" . $e->getMessage() . "</div>";
            exit();
        }
    }
  
    public function delete($table, $clause = true, $rowCount = false) {
        $query = "DELETE FROM " . $table;
        if ($clause) {
            $query .= " WHERE " . $clause[0] . " = :" . $clause[0];
        }
        try {
            $query = $this->db->prepare($query);
//            var_dump($query);
            $lines = $query->execute(array($clause[0] => $clause[1]));
            // Retourner le nombre de lignes supprimées
            if ($rowCount) {
                return $lines;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo "<div class='error'>" . $e->getMessage() . "</div>";
            exit();
        }
    }

    public function load($query) {
        $query = $this->db->prepare($query);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

}
