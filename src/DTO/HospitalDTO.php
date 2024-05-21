<?php
namespace App\DTO;
class HospitalDTO
{
    public $name;
    public $position;
    // public $doctor_ids;

    public function __construct($name, $position){
        $this->name = $name;
        $this->position = $position;
        // $this->doctor_ids = $doctor_ids;
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function getPosition(): ?string{
        return $this->position;
    }
  
    
}