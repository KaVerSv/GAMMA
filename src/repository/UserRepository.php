<?php

require_once 'PostRepository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/userProfile.php';

class UserRepository extends PostRepository
{
    public function isEmailUnique(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchColumn() == 0;
    }

    public function isLoginUnique(string $login): bool
    {
        $stmt = $this->database->connect()->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchColumn() == 0;
    }

    public function isEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password'],
            $userData['name'],
            $userData['surname'],
            $userData['login'],
            $userData['type']
        );
    }

    public function getUserProfile(int $user_id){
        $stmt = $this->database->connect()->prepare('
        SELECT u.id, u.name, u.surname, u_p.image_path, u_p.description, u_p.visibility FROM users u 
        JOIN user_profiles u_p ON u.id = u_p.id WHERE u.id = ?');
        $stmt->execute([$user_id]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $user_profile = new UserProfile(
            $userData['id'],
            $userData['name'],
            $userData['surname'],
            $userpData['image_path'],
            $userData['description'],
        );

        $user_profile->setPosts($this->getUserPosts($user_profile->getId()));

        return $user_profile;
    }

    public function search(string $search){
        $dane_osobowe = explode(" ", $search);
        $stmt = $this->database->connect()->prepare('
            SELECT u.id, u.name, u.surname, u_p.image_path, u_p.description, u_p.visibility 
            FROM users u 
            JOIN user_profiles u_p ON u.id = u_p.id 
            WHERE (u.name ILIKE ? OR u.name ILIKE ? OR u.surname ILIKE ? OR u.surname ILIKE ?)
        ');
    
        if (empty($dane_osobowe[1])) {
            $stmt->execute(["%$dane_osobowe[0]%", "%$dane_osobowe[0]%", "%$dane_osobowe[0]%", "%$dane_osobowe[0]%"]);
        } else {
            $stmt->execute(["%$dane_osobowe[0]%", "%$dane_osobowe[1]%", "%$dane_osobowe[0]%", "%$dane_osobowe[1]%"]);
        }
    
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $found_users = [];
    
        foreach($usersData as $userData){
            $found_users[] = new UserProfile(
                $userData['id'],
                $userData['name'],
                $userData['surname'],
                $userData['image_path'],
                $userData['description']
            );
        }
    
        return $found_users;
    }
    
    

    public function addUser(User $user)
    {
        if (!$this->isEmailUnique($user->getEmail())) {
            throw new Exception('Email is not unique.');
        }

        if (!$this->isLoginUnique($user->getLogin())) {
            throw new Exception('Login is not unique.');
        }

        if (!$this->isEmailValid($user->getEmail())) {
            throw new Exception('Invalid email format.');
        }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (id, name, surname, email, login, password, type)
            VALUES (DEFAULT, :name, :surname, :email, :login, :password, :type)
        ');

        $stmt->bindParam(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':login', $user->getLogin(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':type', $user->getType(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('Error adding user.');
        }
    }

    public function getUserById(int $id): ?string
    {
        $stmt = $this->database->connect()->prepare('SELECT name FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userName = $stmt->fetchColumn();

        return $userName ? $userName : null;
    }
}