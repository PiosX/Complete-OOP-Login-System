<?php 
    namespace Class\Model;

    use Class\Config\Dbh; 

    class User extends Dbh
    {
        protected function checkUser(string $login, string $email) {
            $sql = "SELECT id FROM user WHERE login = ? OR email = ?";
            $stmt = $this->connect()->prepare($sql);

            if(!$stmt->execute(array($login, $email))) {
                $stmt = null;
                header('location: index.php?error=stmtfailed');
                exit();
            }

            if($stmt->rowCount() > 0) {
                $result = false;
            } 
            else {
                $result = true;
            }

            return $result;
        }

        protected function setUser(string $login, string $email, string $password) {
            trim($login);
            trim($email);
            $sql = "INSERT INTO user (login, email, password) VALUES (?,?,?)";
            $stmt = $this->connect()->prepare($sql);

            $cost = array('cost' => 12);
            $hashPwd = password_hash($password, PASSWORD_BCRYPT, $cost);

            if(!$stmt->execute(array($login,$email,$hashPwd))) {
                $stmt = null;
                header('location: index.php?error=adduser');
                exit();
            }
            $stmt = null;
        }

        protected function getUser($email,$password)
        {
            $email = trim($email);
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);
            
            if(!$stmt->execute(array($email))) {
                $stmt = null;
                header("location: index.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount()>0)
            {
                $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                if(password_verify($password, $row[0]['password']))
                {                  
                    session_start();
                    $_SESSION['email'] = $row[0]['email'];
                    $_SESSION['login'] = $row[0]['login'];
                }
                else {
                    $stmt = null;
                    header("location: index.php?error=wrongpassword");
                    exit();
                }
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: index.php?error=wrongemail");
                exit();
            }
            $stmt = null;
        }     
    }