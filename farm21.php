<?php

abstract class Pet{
    protected $id;
    protected $minProd;
    protected $maxProd;
    protected $productType;
    
    public function getProduct() {
        $productAmount = rand($this->minProd, $this->maxProd);
        return $productAmount;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
     public function getId() {
        return $this->id;
    }
    
}

class Chicken extends Pet {
    protected $minProd = 0;
    protected $maxProd = 1;
    protected $productType = 'egg';
}

class Cow extends Pet {
    protected $minProd = 8;
    protected $maxProd = 12;
    protected $productType = 'milk';
}

class Farm {
    private $cows;
    private $chickens;


    public function __construct($cowQuantity = 7, $chickenQuantity = 15) {
        $this->cows = $this->generate('Cow', $cowQuantity);
        $this->chickens = $this->generate('Chicken', $chickenQuantity);
    }


    private function generate($type, $quantity) {
        $petArray = [];
        for ($i=1;$i<=$quantity;$i++) {
            $pet = new $type;
            $pet->setId($i);
            array_push($petArray, $pet);
        }
        return $petArray;
    }

    
    
    public function getProducts() {
        $milk = 0;
        $eggs = 0;

        foreach ($this->cows as $cow) {
            $milk += $cow->getProduct();
        }

        foreach ($this->chickens as $chicken) {
            $eggs += $chicken->getProduct();
        }

        $products = ['milk' => $milk, 'eggs' => $eggs];
        return $products;
    }

}

//-------------------------- my new class----
class FarmStatistics  { 
    private $eggs=0;
    private $milk=0;
    private $op=0;
    
    public function getStat($products)  {
            
            $this->op++;
            $this->eggs+=$products['eggs'];
            $this->milk+=$products['milk'];
            $aveEggs=$this->eggs/$this->op;
            $aveMilk=$this->milk/$this->op;
            $stat=['milk' => $this->milk, 'eggs' => $this->eggs,
            'op' => $this->op, 'aveEggs' =>$aveEggs, 'aveMilk' =>$aveMilk];
            return $stat;
    }
}
//----------------------------


$farm = new Farm();
$farmstat=new FarmStatistics();

for ($i=1;$i<=100;$i++)  {
   $products = $farm->getProducts();
   $stat=$farmstat->getStat($products);
  
   echo($stat['op']. PHP_EOL);
   $format = 'Молоко: %4d л  всего: %4d л  среднее: %01.2f л ';
   echo sprintf($format, $products['milk'], $stat['milk'] ,$stat['aveMilk']). PHP_EOL;
   $format = 'Яйца:   %4d шт всего: %4d шт среднее: %01.2f шт ';
   echo sprintf($format, $products['eggs'], $stat['eggs'] ,$stat['aveEggs']). PHP_EOL;
}



?>
