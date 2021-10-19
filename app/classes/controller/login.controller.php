<?php
    namespace Class\Controller;

    use Class\Model\User;

    class LoginController extends User
    {
        private string $email;
        private string $password;

        public function __construct($email, $password) {
            $this->email = $email;
            $this->password = $password;
        }

        public function loginUser() {
            if($this->emptyImput() == false) {
                header("location: index.php?error=emptyimput");
                exit();
            }

            $this->getUser($this->email,$this->password);
        }

        private function emptyImput() {
            if(empty($this->email) || empty($this->password)) {
                $result = false;
            }
            else {
                $result = true;
            }
            return $result;
        }

        
    }