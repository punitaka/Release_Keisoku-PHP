<?php
// MySQL処理用ユーティリティ
	
	
/**
 * DBに接続し、PDOインスタンスを返す
 */
function initDB($db_name) {
  
    //$dsn = 'sqlite:' . $db_file_path; 
    $dsn = 'mysql:dbname=' . $db_name . ';host=localhost;port=3307'; 
    $user = 'ひみつ';
    $password = 'ひみつ';

    try {
        $dbh = new PDO( $dsn, $user, $password );
        if ($dbh) {
            //printf("DBオープン成功");
            return $dbh;
        } else {
            printf("DBオープン失敗");
        }
    } catch ( PDOException $e ) {
        print('Error: initSQLite() ' . $e->getMessage());
//        die();
    }  
    return NULL;
}	


