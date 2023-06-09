<?php

class Session
{
    public function __construct()
    {
        // Alleen een sessie starten, als die nog niet gestart is
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        } //OF: if(session_status() === PHP_SESSION_NONE) {session_start();}
    }

    public function setLogin($username)
    {
        $_SESSION["username"] = $username;
    }

    // onderstaande sessie wordt gebruikt voor auto-aanvullen email wanneer een formulier (opnieuw) moet worden ingevuld
// (bijvoorbeeld bij niet-matchende wachtwoorden bij het aanmaken van een account, of wanneer de gebruiker zijn accountgegevens/wachtwoord wil veranderen) 
    public function setEmail($email)
    {
        $_SESSION["email"] = $email;
    }

    public function logout()
    {
        session_destroy();
    }
}