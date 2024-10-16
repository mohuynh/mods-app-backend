<?php

class Modder {
      
      private $name;
      private $mdp;
      private $creation_date;

       
      public function getName()
      {
            return $this->name;
      }

    
      public function setName($name)
      {
            $this->name = $name;

            return $this;
      }


      public function getCreationDate()
      {
            return $this->creation_date;
      }


      public function setCreationDate($creation_date)
      {
            $this->creation_date = $creation_date;

            return $this;
      }


      public function getMdp()
      {
            return $this->mdp;
      }


      public function setMdp($mdp)
      {
            $this->mdp = $mdp;

            return $this;
      }
}