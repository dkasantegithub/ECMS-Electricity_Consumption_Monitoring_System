<?php

    class User {
        //properties
        private $db;
        public $loginError;
        public $sError;

        //connection to database
        public function __construct($db_connection) {
            $this->db = $db_connection;
        }

        //Login function
        public function login($username, $email, $password){
            $username = $this->validate_data($username);
            $email = $this->validate_data($email);
            $password = $this->validate_data($password);

            if(empty($username) || empty($email) || empty($password)){
                $this->loginError = "Username and password are required";
            }else{
                try{
                    #fetch data from database
                    $stmt = $this->db->prepare("SELECT * FROM adminregister WHERE username=:username OR email=:email LIMIT 1");
                    $stmt->execute(array(":username"=>$username, ":email"=>$email));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    //verify whether data exists
                    if($stmt->rowCount() >  0){
                        if(password_verify($password, $row["password"])){
                        $_SESSION["user_session"] = $row["admin_id"];
                        
                        return true;
                        }else{
                        $this->loginError = "Username or password is incorrect";
                        return false;
                        }
                    }else{
                        $this->loginError = "Username or password is incorrect";
                        return false;
                        }

                }catch(PDOException $e){
                    echo "Login Error: " . $e->getMessage();
                }
            }
        }



        //Signup page
        public function signup($fname, $lname, $username, $email, $password, $cpassword, $role){
            //trim input
            $fname = $this->validate_data($fname);
            $lname = $this->validate_data($lname);
            $username = $this->validate_data($username);
            $email = $this->validate_data($email);
            $password = $this->validate_data($password);
            $cpassword = $this->validate_data($cpassword);

            //check whether input is empty
            if(empty($fname) || empty($lname) || empty($username) || empty($email)
             || empty($password) || empty($cpassword)){
                $this->sError = "Input fields are required";
                
            //validate names
            }elseif(!$this->validate_name($fname) || !$this->validate_name($lname) || 
                    !$this->validate_name($username)){
                        $this->sError = "Names should be only alphabets";

            //validate name-length
            }elseif(!$this->character_len($fname, 20) || !$this->character_len($lname, 20) || 
                    !$this->character_len($username, 20)){
                        $this->sError = "Names should be less than 20 characters";
            
            //validate email
            }elseif(!$this->email($email)){
                        $this->sError = "Invalid email format";
            
            //validate password
            }elseif(!$this->validate_pwd($password)){
                        $this->sError = "Password must be atleast 10 characters";
            
            //confirm password
            }elseif($password != $cpassword){
                        $this->sError = "passwords must match";

            }else{
                try{
                    //check whether username or email exist
                    $check = $this->db->prepare("SELECT username, email FROM adminregister 
                    WHERE username=:uname OR email=:umail");
                    $check->execute(array(':uname'=>$username, ':umail'=>$email));
                    $row = $check->fetch(PDO::FETCH_ASSOC);

                    if($row['username']==$username){
                        $this->sError = "username already exist!";

                    }elseif($row['email']==$email){
                        $this->sError = "email already exist!";

                    }else{
                    //hash password
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    //insert data into db
                    $stmt = $this->db->prepare("INSERT INTO adminregister(fname, lname, username, email, password, admin_role)
                    VALUES(:fname, :lname, :username, :email, :password, '$role')");

                            $stmt->bindparam(":fname", $fname);
                            $stmt->bindparam(":lname", $lname);
                            $stmt->bindparam(":username", $username);
                            $stmt->bindparam(":email", $email);
                            $stmt->bindparam(":password", $pwd);
                            $stmt->execute();
                            return $stmt;
                    }

                }catch(PDOException $e){
                      $this->sError = "Signup Error: " .$e->getMessage();
                }
                $this->db = null;
            }
        }



        //is logged in
        public function is_loggedin(){
            if(isset($_SESSION["user_session"])){
                return true;
            }
        }

        //logout
        public function logout(){
            session_destroy();
            unset($_SESSION["user_session"]);
            return true;
        }

        //Redirect
        public function redirect($page){
            return header("Location: $page");
        }

        //remove unnecessary characters from input
        private function validate_data($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //validate text input
        private function validate_name($name){
            return preg_match("/^[a-zA-Z]+$/", $name);
        }

         //validate name length
        private function character_len($char, $max){
            return strlen($char) < $max;
        }

        //validate email
        private function email($email){
            return filter_var($email,FILTER_VALIDATE_EMAIL);
        }

          //validate password
        private function validate_pwd($pwd){
            return preg_match("/^[a-zA-Z0-9-@#'$]{10,}+$/", $pwd);
        }
        
    }
?>