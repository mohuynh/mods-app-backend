<?php

class Mod {

      private $name;
      private $expansion; 
      private $type;
      private $age;
      private $gender;
      private $clothing_category;
      private $size;
      private $id_author;

      
      public function getName()
      {
            return $this->name;
      }


      public function setName($name)
      {
            $this->name = $name;

            return $this;
      }


      public function getExpansion()
      {
            return $this->expansion;
      }

    
      public function setExpansion($expansion)
      {
            $this->expansion = $expansion;

            return $this;
      }

       
      public function getType()
      {
            return $this->type;
      }

 
      public function setType($type)
      {
            $this->type = $type;

            return $this;
      }

      

      public function getAge()
      {
            return $this->age;
      }

      public function setAge($age)
      {
            $this->age = $age;

            return $this;
      }

     
      public function getGender()
      {
            return $this->gender;
      }

      public function setGender($gender)
      {
            $this->gender = $gender;

            return $this;
      }

       
      public function getClothingCategory()
      {
            return $this->clothing_category;
      }

     
      public function setClothingCategory($clothing_category)
      {
            $this->clothing_category = $clothing_category;

            return $this;
      }

   
      public function getSize()
      {
            return $this->size;
      }

     
      public function setSize($size)
      {
            $this->size = $size;

            return $this;
      }

      
      public function getIdAuthor()
      {
            return $this->id_author;
      }

     
      public function setIdAuthor($id_author)
      {
            $this->id_author = $id_author;

            return $this;
      }
}