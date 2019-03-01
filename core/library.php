<?php
require 'database.php';
/*
 * giokalm
 *
 * Page: Application library
 * */

class Library
{

    /*
     * Register New User
     * INSERT INTO `user`(`usr_id`, `usr_name`, `usr_email`, `usr_key`) VALUES ()
     * @param $name, $email, $username, $password
     * @return ID
     * */
    public function Register($firstname, $lastname, $email, $password, $role)
    {
        try {
            $db = DB();
            $fullname = $firstname." ".$lastname;
            $now = date("Y-m-d H:i:s");
            $enc_password = hash('sha256', $password);
            $query = $db->prepare("INSERT INTO `user`(`usr_created`,`usr_name`, `usr_email`, `usr_key`, `usr_role`) VALUES (:d,:n,:e,:p, :r)");
            $query->bindParam("d", $now, PDO::PARAM_STR);
            $query->bindParam("n", $fullname, PDO::PARAM_STR);
            $query->bindParam("e", $email, PDO::PARAM_STR);
            $query->bindParam("p", $enc_password, PDO::PARAM_STR);
            $query->bindParam("r", $role, PDO::PARAM_INT);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Insert new lesson
     * INSERT INTO `lesson`(`le_name`) VALUES ()
     * @param $name, $email, $username, $password
     * @return ID
     * */
    public function new_lesson($name)
    {
        try {
            $db = DB();

            $query = $db->prepare("INSERT INTO `lesson`(`le_name`) VALUES (:n)");
            $query->bindParam("n", $name, PDO::PARAM_STR);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function new_tag($name)
    {
        try {
            $db = DB();

            $query = $db->prepare("INSERT INTO `tag`(`tag_name`) VALUES (:n)");
            $query->bindParam("n", $name, PDO::PARAM_STR);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Insert new lesson
     * INSERT INTO `student`(`stu_name`, `stu_guardian_id`) VALUES ([value-1],[value-2])
     * @param $firstname, $lastname, $guardian
     * @return ID
     * */
    public function new_student($firstname, $lastname, $guardian)
    {
        try {
            $db = DB();
            $fullname = $firstname." ".$lastname;
            $query = $db->prepare("INSERT INTO `student`(`stu_name`, `stu_guardian_id`) VALUES (:n,:g)");
            $query->bindParam("n", $fullname, PDO::PARAM_STR);
            $query->bindParam("g", $guardian, PDO::PARAM_INT);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    
    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */
    public function isEmail($email)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT `usr_id` FROM `user` WHERE `usr_email` = :e");
            $query->bindParam("e", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Login
     *
     * @param $username, $password
     * @return $mixed
     * */
    public function Login($username, $password)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE (username=:username OR email=:username) AND password=:password");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }



    /*
     * get Users
     * @return $mixed
     * */
    public function get_all_users($role)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `user` WHERE `usr_role` = :r");
            $query->bindParam("r", $role, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetchAll();
            }
            else
            {
                return 0;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function get_user_name($id)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT `usr_name` FROM `user` WHERE `usr_id` = :id");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->usr_name;
            }
            else
            {
                return 0;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    

    /*
     * get lessons
     * @return $mixed
     * 
     * */
    public function get_all_lessons()
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `lesson`");
            $query->execute();
            if ($query->rowCount() > 0) 
            {
                return $query->fetchAll();
            }
            else
            {
                return 0;
            }
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }

    public function get_all_tags()
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `tag`");
            $query->execute();
            return $query->fetchAll();
            
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }

    public function get_student_lessons($id)
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT `at_lesson_id` FROM `attends` WHERE `at_student_id` = :id ");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
            
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }

    //avail_lessons
    // SELECT * FROM `lesson` WHERE `le_id` NOT IN (SELECT `at_lesson_id` FROM `attends` WHERE `at_student_id` = student_id)
    
    public function get_available_lessons($id)
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `lesson` WHERE `le_id` NOT IN (SELECT `at_lesson_id` FROM `attends` WHERE `at_student_id` = :id)");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }

    public function get_lesson_name($id)
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT `le_name` FROM `lesson` WHERE `le_id` = :id ");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }

    public function get_all_students()
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `student`");
            $query->execute();
            if ($query->rowCount() > 0) 
            {
                return $query->fetchAll();
            }
            else
            {
                return 0;
            }
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }


    public function get_student($id)
    {
        try 
        {
            $db = DB();
            $query = $db->prepare("SELECT * FROM `student` WHERE `stu_id` = :id ");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0)
            {
                $result = $query->fetch();
                return $result;
            }
            else
            {
                return 0;
            }
        } 
        catch (PDOException $e) 
        {
            exit($e->getMessage());
        }
    }


    public function new_student_lesson($student, $lesson)
    {
        try {
            $db = DB();
            
            $query = $db->prepare("INSERT INTO `attends`(`at_student_id`, `at_lesson_id`) VALUES (:s,:l)");
            $query->bindParam("s", $student, PDO::PARAM_STR);
            $query->bindParam("l", $lesson, PDO::PARAM_INT);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

}