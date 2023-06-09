<?php

class FormValidation
{
  public function form_input($userData)
  {
    $userData = trim($userData);
    $userData = stripslashes($userData);
    $userData = htmlspecialchars($userData);
    return $userData;
  }
} // evt. nog UITBREIDEN met bijvoorbeeld validatie correct e-mailadres, of een (nieuw) wachtwoord voldoet aan bepaalde minimumeisen etc.