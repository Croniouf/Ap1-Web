<?php

class Livre {
    public $ISBN;
    public $Titre;
    public $Prix;
    public $Dispo;

    public function __construct($ISBN, $Titre, $Prix, $Dispo) {
        $this->ISBN = $ISBN;
        $this->Titre = $Titre;
        $this->Prix = $Prix;
        $this->Dispo = $Dispo;
    }

    public function getISBN() {
        return $this->ISBN;
    }

    public function setISBN($ISBN) {
        $this->ISBN = $ISBN;
    }

    public function getTitre() {
        return $this->Titre;
    }

    public function setTitre($Titre) {
        $this->Titre = $Titre;
    }

    public function getPrix() {
        return $this->Prix;
    }

    public function setPrix($Prix) {
        $this->Prix = $Prix;
    }

    public function getDispo() {
        return $this->Dispo;
    }

    public function setDispo($Dispo) {
        $this->Dispo = $Dispo;
    }
}

$Livre1=new Livre ("EEE032", "Programmer en C", 10,1);
$Livre2=new Livre ("JAV44", "Programmer en java", 50,1);
echo $Livre1->getLibelle();


$Disctionnaire = array();
$Disctionnaire[$Livre1->getISBN]=$Livre1;
$Disctionnaire[$Livre2->getISBN]=$Livre2;


?>
