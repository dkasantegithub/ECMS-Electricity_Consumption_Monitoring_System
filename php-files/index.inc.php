<?php

    class User {
        private $db;
        public $loginError;
        public $signupError;
        public $ferror;
        public $lerror;
        public $uerror; 
        public $eerror;
        public $perror;
        public $ecpwd;

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
                    $stmt = $this->db->prepare("SELECT * FROM signup WHERE username=:username OR email=:email LIMIT 1");
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
        public function signup($fname, $lname, $username, $email, $password, $cpassword){
            $fname = $this->validate_data($fname);
            $lname = $this->validate_data($lname);
            $username = $this->validate_data($username);
            $email = $this->validate_data($email);
            $password = $this->validate_data($password);
            $cpassword = $this->validate_name($cpassword);

            if(empty($fname) || empty($lname) || empty($username) || empty($email)
             || empty($password) || empty($cpassword)){
                $this->signupError = "Input fields are required";

            }elseif(!$this->validate_name($fname)){
                $this->fname = "only alphabets,',- are required";
            }elseif(!$this->character_len($fname, 12)){
                $this->fname = "name is too long";
            }elseif(!$this->validate_name($lname)){
                $this->lname = "only alphabets,',- are required";
            }elseif(!$this->character_len($lname, 12)){
                $this->lname = "name is too long";
            }elseif(!$this->validate_name($username)){
                $this->username = "only alphabets,',- are required";
            }elseif(!$this->character_len($username, 12)){
                $this->username = "name is too long";
            }elseif($this->email($email)){
                $this->eerror = "Invalid email format";
            }elseif($this->password != $this->cpassword){
                $this->ecpwd = "password must match";
            }else{
                try{
                    //hash password
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    //insert data into db
                    $stmt = $this->db->prepare("INSERT INTO signup(fname, lname, username, email, password)
                            VALUES(:fname, :lname, :username, :email, :password)");

                            $stmt->bindparam(":fname", $fname);
                            $stmt->bindparam(":lname", $lname);
                            $stmt->bindparam(":username", $username);
                            $stmt->bindparam(":email", $email);
                            $stmt->bindparam(":password", $password);
                            $stmt->execute();

                            return $stmt;

                }catch(PDOException $e){
                    echo "Signup Error: " .$e->getMessage();
                }
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

        //remove unnecessary characters from input
        private function validate_data($data){

            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Redirect
        public function redirect($page){
            return header("location: $page");
        }

        //validate text input
        private function validate_name($name){
            return preg_match("/^[a-zA-Z'-]+$/", $name);
        }

        //validate email
        private function email($email){
            return filter_var($email,FILTER_VALIDATE_EMAIL);
        }

        //validate name length
        private function character_len($char, $max){
            return strlen($char) < $max;
        }
    }
?>