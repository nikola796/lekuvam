<?php
namespace App\Models;

use App\Core\App;
use Connection;
use PDO;
use PDOException;

class Post
{

    private $db;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $conf = App::get('config');

        $this->db = Connection::make($conf['database']);
    }

    /**
     * GET ALL POSTS
     * @return array
     */
    public function getAllPost()
    {

        $sql = 'SELECT p.*, group_concat(f.id SEPARATOR "; ") AS file_id, group_concat(f.label SEPARATOR "; ") AS label,group_concat(f.original_filename SEPARATOR "; ") AS file_name, nc.name AS folder, u.name AS username FROM posts AS p
                                              LEFT JOIN files AS f ON (p.id=f.post_id) 
                                              LEFT JOIN ' . NESTED_CATEGORIES . '  AS nc ON (p.directory=nc.category_id) 
                                              LEFT JOIN users AS u ON (p.added_from=u.id) ';

        //$sql = $this->userAccess($sql);

        $sql .= ' WHERE p.added_from = '. $_SESSION['user_id'] .' GROUP BY p.id ORDER BY p.added_when';

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    private function userAccess($sql)
    {
        // if ($_SESSION['role'] > 1) {
        //     $user = new User();
        //     $user_access = $user->getUserAccess($_SESSION['user_id']);
        //     foreach ($user_access as $ua) {
        //         //echo $ua->folder_id;
        //         $stmt = $this->db->prepare('SELECT  `lft`,  `rgt` FROM ' . NESTED_CATEGORIES . '  WHERE category_id = ?');
        //         $stmt->execute(array($ua->folder_id));
        //         $params[] = $stmt->fetchAll(PDO::FETCH_CLASS);
        //     }

        //     $nsql = 'SELECT category_id FROM nested_categories WHERE lft BETWEEN ';

        //     foreach ($params as $k => $param) {
        //         $nsql .= $param[0]->lft . ' AND ' . $param[0]->rgt;
        //         // echo $k.'<br />';
        //         if (($k + 1) < count($params)) {
        //             $nsql .= ' OR lft BETWEEN ';
        //         }
        //     }

        //     $stmt = $this->db->prepare($nsql);
        //     $stmt->execute();
        //     $user_access_folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //     $cats = implode(', ', array_map(function ($entry) {
        //         return $entry['category_id'];
        //     }, $user_access_folders));


        //     $sql .= ' WHERE p.directory IN (' . $cats . ')';

        // }
        //dd($sql);
        return $sql;
    }

    public function create($params)
    {

        //if ($params['new_sort_number'] && $params['old_sort_number']) {

//            if($params['old_sort_number'] < $params['new_sort_number']){
//                $symbol = '-';
//                $sign1 = '>';
//                $sign2 = '<=';
//            } else{
//                $symbol = '+';
//                $sign1 = '<';
//                $sign2 = '>=';
//            }

            try {
                $this->db->beginTransaction();

//                $stmt = $this->db->prepare('SELECT  @parent := directory FROM posts WHERE category_id = ?');
//                $stmt->execute(array($params['folder_id']));

                // $stmt = $this->db->prepare('UPDATE ' . NESTED_CATEGORIES . ' SET sort_number = (sort_number + 1) WHERE parent_id =:directory AND sort_number >=:sort_number');
                // $stmt->execute(array('directory' => $params['directory_id'], 'sort_number' => $params['new_sort_number']));

                // $stmt = $this->db->prepare('UPDATE files SET sort_number = (sort_number + 1) WHERE directory =:directory AND sort_number > :sort_number AND post_id IS NULL');
                // $stmt->execute(array('directory' => $params['directory_id'], 'sort_number' => $params['new_sort_number']));

                // $stmt = $this->db->prepare('UPDATE posts SET sort_number = (sort_number + 1) WHERE directory = :directory AND sort_number > :sort_number');
                // $stmt->execute(array('directory' => $params['directory_id'], 'sort_number' => $params['new_sort_number']));

                // unset($params['old_sort_number']);

                $stmt = $this->db->prepare('INSERT INTO illness (patient,simptome,treatment,physician,notes, user_id) VALUES (:patient, :simptome, :treatment, :physician, :notes, ' . $_SESSION['user_id'] . ')');

                $stmt->execute($params);

                $id = $this->db->lastInsertId();

                $this->db->commit();

            } catch (PDOException $ex) {
                $this->db->rollBack();
                echo $ex->getMessage();
            }

        //} else {
        //     try {
        //         $stmt = $this->db->prepare('INSERT INTO posts (post,attachment,directory,department,added_from,added_when,sort_number,type, amount,relatedTo) VALUES(:text, :file, :directory_id, :department_id, ' . $_SESSION['user_id'] . ', ' . time() . ',:new_sort_number, :post_type, :postAmount, :post_date)');

        //         $stmt->execute($params);

        //         $id = $this->db->lastInsertId();

        //     } catch (Exception $e) {
        //         echo $e->getMessage();
        //     }
        // }
        return $id;

    }

    /**
     * UPDATE POSTS
     * @param array $params
     */
    public function updatePost($params = array())
    {

        $existing_files = array_splice($params, 3, 1);

        $removed_files = array_splice($params, 3, 1);

        $removed_files_name = array_splice($params, 3, 1);

        //echo '<pre>' . print_r($removed_files, true) . '</pre>';die();
//        if (($removed_files_name['removed_files_name'][0])) {
//            foreach ($removed_files_name['removed_files_name'] as $v) {
//                foreach ($v as $vv) {
//                    $vvv[] = $vv['original_filename'];
//                };
//            }
//
//        }
        $department = App::get('database')->getFolderDepartment($params['folder']);

        $ex_files = $existing_files['existing_file'];

        $rm_files = $removed_files['removed_files'];

        if (isset($_FILES['userfile']) || $ex_files != 0) {
            $attached = 1;

        } else {
            $attached = 0;
        }

        try {
            $this->db->beginTransaction();
            if($params['old_parent']){

                /** UPDATE posts TABLE */
                $stmt = $this->db->prepare('UPDATE posts SET sort_number = (sort_number + 1) WHERE directory = :folder AND sort_number >= :new_sort_number');
                $stmt->execute(array('folder' => $params['folder'], 'new_sort_number' => $params['new_sort_number']));

                $stmt = $this->db->prepare('UPDATE posts SET sort_number = (sort_number - 1) WHERE directory = :old_parent AND sort_number > :old_sort_number');
                $stmt->execute(array('old_parent' => $params['old_parent'], 'old_sort_number' => $params['old_sort_number']));

                /** UPDATE FOLDERS TABLE */
                $stmt = $this->db->prepare('UPDATE ' . NESTED_CATEGORIES . ' SET sort_number = (sort_number + 1) WHERE parent_id = :folder AND sort_number >= :new_sort_number ');
                $stmt->execute(array('folder' => $params['folder'], 'new_sort_number' => $params['new_sort_number']));

                $stmt = $this->db->prepare('UPDATE ' . NESTED_CATEGORIES . ' SET sort_number = (sort_number - 1) WHERE parent_id = :old_parent AND sort_number > :old_sort_number');
                $stmt->execute(array('old_parent' => $params['old_parent'], 'old_sort_number' => $params['old_sort_number']));

                /** UPDATE FILES TABLE */
                $stmt = $this->db->prepare('UPDATE files SET sort_number = (sort_number + 1) WHERE directory = :folder AND sort_number >= :new_sort_number AND post_id IS NULL');
                $stmt->execute(array('folder' => $params['folder'], 'new_sort_number' => $params['new_sort_number']));
                if($attached === 1){
                    $stmt = $this->db->prepare('UPDATE files SET directory = :folder, department_id = ' . $department . ' WHERE post_id = :post_id');
                    $stmt->execute(array('post_id' => $params['post_id'], 'folder' => $params['folder']));
                }

                $stmt = $this->db->prepare('UPDATE files SET sort_number = (sort_number - 1) WHERE directory = :old_parent AND sort_number > :old_sort_number AND post_id IS NULL');
                $stmt->execute(array('old_parent' => $params['old_parent'], 'old_sort_number' => $params['old_sort_number']));

                /**  REMOVE OLD SORT VALUE AND OLD_PARENT FROM ARRAY */
                unset($params['old_sort_number']);
                unset($params['old_parent']);

                /** UPDATE posts TABLE */
                $stmt = $this->db->prepare('UPDATE posts SET post = :post, attachment = ' . $attached . ', directory = :folder, department = ' . $department . ', added_from = ' . $_SESSION['user_id'] . ', sort_number = :new_sort_number WHERE id = :post_id');
                $stmt->execute($params);
                $resp = $stmt->rowCount();
            }

             elseif ($params['new_sort_number'] && $params['old_sort_number']) {
                if ($params['old_sort_number'] < $params['new_sort_number']) {
                    $symbol = '-';
                    $sign1 = '>';
                    $sign2 = '<=';
                } else {
                    $symbol = '+';
                    $sign1 = '<';
                    $sign2 = '>=';
                }

                /** SELECT PARENT FOLDER ID */
                $stmt = $this->db->prepare('SELECT  @parent := directory FROM posts WHERE id = ?');
                $stmt->execute(array($params['post_id']));

                /** UPDATE posts TABLE */
                $stmt = $this->db->prepare('UPDATE posts SET sort_number = (sort_number ' . $symbol . ' 1) WHERE directory = @parent AND sort_number ' . $sign1 . ' ? AND sort_number ' . $sign2 . ' ?');
                $stmt->execute(array($params['old_sort_number'], $params['new_sort_number']));

                /** UPDATE FOLDERS TABLE */
                $stmt = $this->db->prepare('UPDATE ' . NESTED_CATEGORIES . ' SET sort_number = (sort_number ' . $symbol . ' 1) WHERE parent_id = @parent AND sort_number ' . $sign1 . ' ? AND sort_number ' . $sign2 . ' ?');
                $stmt->execute(array($params['old_sort_number'], $params['new_sort_number']));

                /** UPDATE FILES TABLE */
                $stmt = $this->db->prepare('UPDATE files SET sort_number = (sort_number ' . $symbol . ' 1) WHERE directory = @parent AND sort_number ' . $sign1 . ' ? AND sort_number ' . $sign2 . ' ? AND post_id IS NULL');
                $stmt->execute(array($params['old_sort_number'], $params['new_sort_number']));

                /**  REMOVE OLD SORT VALUE FROM ARRAY */
                unset($params['old_sort_number']);

                /** UPDATE posts TABLE */
                $stmt = $this->db->prepare('UPDATE posts SET post = :post, attachment = ' . $attached . ', directory = :folder, department = ' . $department . ', added_from = ' . $_SESSION['user_id'] . ', sort_number = :new_sort_number WHERE id = :post_id');
                $stmt->execute($params);
                $resp = $stmt->rowCount();


            } else {
                $stmt = $this->db->prepare('UPDATE posts SET post = :post, attachment = ' . $attached . ', directory = :folder, department = ' . $department . ', added_from = ' . $_SESSION['user_id'] . ' WHERE id = :post_id');
                $stmt->execute($params);
                $resp = $stmt->rowCount();
            }
            $this->db->commit();
            $response = array();
            //if ($resp > 0) {
            $response['succss_update_post'] .= 'Успешно обновихте Вашия пост';
            // }

            if ($rm_files != 0) {

                $file = new File();
                $file->deleteFile($rm_files);
            }
            
            if (isset($_FILES['userfile'])) {
                $file = new File();
                $response += $file->fileUpload2($params['post_id'], array('act' => 'edit', 'department_id' => $department));
            }


            if ($removed_files_name['removed_files_name']) {

                $response['removed_files_are'] = 'Успешно премахнахте файл';
                if (count($removed_files_name['removed_files_name']) > 1) {
                    $response['removed_files_are'] .= 'ове: ' . implode(', ', $removed_files_name['removed_files_name']);
                } else {
                    $response['removed_files_are'] .= ': ' . implode(', ', $removed_files_name['removed_files_name']);
                }

            }

            $_SESSION['update_post'] = $response;
            redirect('posts');
        } catch (PDOException $ex) {
            $this->db->rollBack();
            echo $ex->getMessage();
        }
    }

    /**
     * DELETE POST BY ID
     * @param $post_id
     * @return array
     */
    public function deletePost($post_id)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('SELECT directory, sort_number FROM posts WHERE id = ?');
            $stmt->execute(array($post_id));
            $row = $stmt->fetchAll(PDO::FETCH_CLASS);

            /** UPDATE sort_number in ALL TABLES */
            $stmt = $this->db->prepare('UPDATE ' . NESTED_CATEGORIES . ' SET sort_number = (sort_number - 1) WHERE parent_id =:directory AND sort_number >=:sort_number');
            $stmt->execute(array('directory' => $row[0]->directory, 'sort_number' => $row[0]->sort_number));

            $stmt = $this->db->prepare('UPDATE files SET sort_number = (sort_number - 1) WHERE directory =:directory AND sort_number > :sort_number AND post_id IS NULL');
            $stmt->execute(array('directory' => $row[0]->directory, 'sort_number' => $row[0]->sort_number));

            $stmt = $this->db->prepare('UPDATE posts SET sort_number = (sort_number - 1) WHERE directory = :directory AND sort_number > :sort_number');
            $stmt->execute(array('directory' => $row[0]->directory, 'sort_number' => $row[0]->sort_number));

            /** DELETE POST */
            $stmt = $this->db->prepare('DELETE FROM posts WHERE id = ?');
            $stmt->execute(array($post_id));
            $row_count = $stmt->rowCount();

            $path = realpath('core/files') . DIRECTORY_SEPARATOR;
            $del_files = 0;

            $stmt = $this->db->prepare('SELECT stored_filename FROM files WHERE post_id = ?');
            $stmt->execute(array($post_id));
            $row = $stmt->fetchAll(PDO::FETCH_CLASS);

            $stmt = $this->db->prepare('DELETE FROM files WHERE post_id = ?');

            foreach ($row as $file) {
                if (unlink($path . $file->stored_filename)) {

                    $del_files += 1;
                }
            }

            if (count($row) == $del_files) {
                $stmt->execute(array($post_id));
            }

            $this->db->commit();

            return array('del_post' => $row_count, 'del_file' => $del_files);
        } catch (PDOException $ex) {
            $this->db->rollBack();
            echo $ex->getMessage();
        }


    }

}