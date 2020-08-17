<?php

use Brick\Db\Bulk\BulkInserter;
use Brick\Db\Bulk\BulkDeleter;

class DB {

    // Member Zone
    var $result;
    var $row_result;
    var $pdo;
    var $database;

    public function __construct($location, $username, $password, $database) {
        try {
            $this->database = $database;
            $pdo = new PDO("mysql:host=$location;dbname=" . $database . "", $username, $password, array(
                PDO::ATTR_PERSISTENT => true
            ));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo = $pdo;
        } catch (PDOException $ex) {
            $this->DBDown($ex);
        }
    }

    function executeSQL($sql) {
        try {
            $sth = $this->pdo->query($sql);
            $this->row_result = 0;
            $this->result = array();
            // print "sql=".$sql."<br>";
            if ((strpos("_" . $sql, 'SELECT')) || (strpos("_" . $sql, 'SHOW')) || (strpos("_" . $sql, 'DESCRIBE')) || (strpos("_" . $sql, 'EXPLAIN'))) {
                // $sth->fetchAll(PDO::FETCH_ASSOC)
                while ($this->result[] = $sth->fetch(PDO::FETCH_NUM)) {
                    $this->row_result ++;
                }
            }
        } catch (PDOException $ex) {
            DB::DBDown($ex);
        }
        // $this->pdo=null;
    }

    function cleanSQL($param) {
        return filter_var($param, FILTER_SANITIZE_STRIPPED);
        // Clean sql parameters
        // return $this->pdo->quote($param, PDO::PARAM_STMT);
        // return mysqli_real_escape_string($this->pdo, $param);
    }

    function DBDown(PDOException $ex) {
        // database down
        print $ex->getMessage();
        exit();
    }

}

class SyncronizeDB {

    var $pdo;
    // With Caution
    var $table_master;
    var $idx_master;
    var $table_slave;
    var $idx_slave;
    var $col_master;
    var $db_master;
    var $db_slave;

    public function __construct() {
        
    }

    function masterColumns() {
        // return columns name
        $this->db_master->executeSQL("SHOW COLUMNS from " . $this->db_master->database . "." . $this->table_master);
        $i = 0;
        $col = "";
        foreach ($this->db_master->result as $row) {
            if ($row != "") {
                if ($i == 1)
                    $col .= ",";
                $col .= $row[0];
                if ($i == 0)
                    $i = 1;
            }
        }
        return $col;
    }

    function masterAllIndexes() {
        // return all index value
        $this->db_master->executeSQL("SELECT " . $this->idx_master . " from " . $this->db_master->database . "." . $this->table_master);
    }

    function masterDataRows($sin) {
        // return data from master database
        $this->db_master->executeSQL("SELECT * from " . $this->db_master->database . "." . $this->table_master . " where " . $this->idx_master . " in (" . $sin . ")");
    }

    function masterSet($mplocation, $mpuser, $mppassword, $mpdb, $mptable, $mpidx) {
        // set master database
        $this->table_master = $mptable;
        $this->idx_master = $mpidx;
        $this->db_master = new DB($mplocation, $mpuser, $mppassword, $mpdb);
        $this->pdo = $this->db_master->pdo;
        $this->col_master = $this->masterColumns();
    }

    function slaveColumns() {
        // return columns name
        $this->db_slave->executeSQL("SHOW COLUMNS from " . $this->db_slave->database . "." . $this->table_slave);
        $i = 0;
        $col = "";
        foreach ($this->db_slave->result as $row) {
            if ($row != "") {
                if ($i == 1)
                    $col .= ",";
                $col .= $row[0];
                if ($i == 0)
                    $i = 1;
            }
        }
        return $col;
    }

    function slaveAllIndexes() {
        // return all index value
        $this->db_slave->executeSQL("SELECT " . $this->idx_slave . " from " . $this->db_slave->database . "." . $this->table_slave);
    }

    function slaveSet($mplocation, $mpuser, $mppassword, $mpdb, $mptable, $mpidx) {
        // set slave database
        $this->table_slave = $mptable;
        $this->idx_slave = $mpidx;
        $this->db_slave = new DB($mplocation, $mpuser, $mppassword, $mpdb);
        $this->pdo = $this->db_slave->pdo;
        // $this->db_slave->Open($mplocation, $mpuser, $mppassword, $mpdb);
        $this->col_slave = $this->slaveColumns();
    }

    // END START
    function slaveSyncronization($thirddatabase) {
        $this->masterAllIndexes();
        $masterid = array();
        foreach ($this->db_master->result as $id) {
            $masterid[] = $id[0];
        }

        $this->slaveAllIndexes();
        $slaveid = array();
        foreach ($this->db_slave->result as $id) {
            $slaveid[] = $id[0];
        }

        $in = array_diff($masterid, $slaveid);
        // echo "Added the data rows with the following ids: ";
        $sin = implode(",", $in);
        if ($sin == "") {
            $inserted = 0;
        } else {
            try {
                $this->masterDataRows($sin);
                // $columns = str_replace(',', '",', $this->col_slave);
                $arraycol_slave = explode(',', $this->col_slave);
                $inserter = new BulkInserter($this->db_slave->pdo, $this->table_slave, $arraycol_slave);
                // BulkInserter $inserter = new BulkInserter($this->db_slave->pdo, $this->table_slave, $arraycol_slave);
                $this->db_slave->pdo->beginTransaction();
                foreach ($this->db_master->result as $row) {
                    if (!empty($row)) {
                        $inserter->queuemore($row);
                    }
                }
                $inserter->flush();
                $this->db_slave->pdo->commit();
                $inserted = 1;
            } catch (Exception $e) {
                echo $e->getMessage();
            } finally {
                $inserter = new BulkInserter($this->db_slave->pdo, $thirddatabase, $arraycol_slave);
                $this->db_slave->pdo->beginTransaction();
                foreach ($this->db_master->result as $row) {
                    if (!empty($row)) {
                        $inserter->queuemore($row);
                    }
                }
                $inserter->flush();
                $this->db_slave->pdo->commit();
            }
        }
        $out = array_diff($slaveid, $masterid);
        // echo "Deleted the data rows with the following ids: ";
        $sout = implode(",", $out);
        if ($sout == "") {
            $_delete = 'none';
        } else {
            $deleter = new BulkDeleter($this->db_slave->pdo, $this->table_slave, [
                $this->idx_slave
            ]);
            $todeletes = explode(',', $sout);
            foreach ($todeletes as $id) {
                $deleter->queue($id);
            }
            $deleter->flush();
            // $sql = "DELETE FROM " . $this->database . "." . $this->table_slave . " where " . $this->idx_slave . " in (" . $sout . ")";
            $_delete = 'deleted';
            // $this->db_slave->executeSQL($sql);
        }
        return array(
            'insertstate' => $inserted,
            'deletedstate' => $_delete
        );
    }

    function getmevalues($rount, $keyword) {
        $valuer = str_replace(',', ',' . $keyword . '', $rount);
        $valuerone = str_replace(',', "'],", $valuer);
        echo $keyword . $valuerone . "']";
    }

    function closeCon($star) {
        switch ($star) {
            case 1:
                $this->db_slave->pdo = null;
                break;
            case 2:
                $this->db_master->pdo = null;
                break;
            default:
                $this->db_slave->pdo = null;
                $this->db_master->pdo = null;
                break;
        }
    }

}
?>