<?php

declare(strict_types=1);

namespace TopicsManager\CPT;

use TopicsManager\Contracts\Registrable;

// use TopicsManager\Contracts\Registrable;

class Taxonomy implements Registrable {

    private string $name;
    private string | array $object_type;
    private string | array $args = [];

    public function __construct(string $name,string | array $object_type,string | array $args = [])
    {
        $this->name = $name;
        $this->object_type = $object_type;
        $this->args = $args;
    }

  public function register(): void{
    register_taxonomy($this->name,$this->object_type,$this->args);
  }


}
