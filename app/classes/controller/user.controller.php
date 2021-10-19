<?php
    namespace Class\Controller;

    use Class\Model\User;

    class UserController extends User
    {
        private string $email;
        private string $login;
        private string $password;
        private string $rep_password;

        public function __construct($email, $login, $password, $rep_password) {
            $this->email = $email;
            $this->login = $login;
            $this->password = $password;
            $this->rep_password = $rep_password;
        }

        public function registerUser() {
            if($this->emptyImput() == false) {
                header("location: index.php?error=emptyimput");
                exit();
            }
            if($this->invalidLogin() == false) {
                header("location: index.php?error=login");
                exit();
            }
            if($this->invalidEmail() == false) {
                header("location: index.php?error=email");
                exit();
            }
            if($this->pwdMatch() == false) {
                header("location: index.php?error=passwordmatch");
                exit();
            }
            if($this->userTakenCheck() == false) {
                header("location: index.php?error=loginoremailtaken");
                exit();
            }

            $this->setUser($this->login, $this->email, $this->password);
        }

        private function emptyImput() {
            if(empty($this->email) || empty($this->login) || empty($this->password) || empty($this->rep_password)) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }

        private function invalidLogin() {
            if(!preg_match('/^[a-z0-9\d_]{2,20}$/i', $this->login)) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }

        private function invalidEmail() {
            if(!filter_var($this->email, FILTER_SANITIZE_EMAIL)) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }

        private function pwdMatch() {
            if($this->password !== $this->rep_password) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }

        private function userTakenCheck() {
            if(!$this->checkUser($this->login, $this->email)) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }
    }