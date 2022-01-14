<?php

class Parameters
{
    const FILE_NAME = 'products.txt';
    const COLUMNS = ['item', 'price'];
    const POPULATION_SIZE = 10;
    const BUDGET = 280000;
    const STOPPING_VALUE = 50000;
    const CROSOVER_RATE = 0.8;
}

class Catalogue
{
    function createProductColumn($listOfRawProduct){
        foreach (array_keys($listOfRawProduct) as $listOfRawProductKey){
            $listOfRawProduct[Parameters::COLUMNS[$listOfRawProductKey]]= $listOfRawProduct[$listOfRawProductKey];
            unset($listOfRawProduct[$listOfRawProductKey]);
        }
        return $listOfRawProduct;
    }
    
    function product(){
        $collectionOfListProduct = [];
        $raw_data = file(Parameters::FILE_NAME);
        foreach ($raw_data as $listOfRawProduct){
             $collectionOfListProduct[] = $this->createProductColumn(explode(",", $listOfRawProduct));
        }
        return $collectionOfListProduct;
    }
}

class Individu
{
    function countNumberOfGen()
    {
        $catalogue = new Catalogue;
        return count($catalogue->product());
    }

    function createRandomIndividu()
    {
        for($i = 0; $i <= $this->countNumberOfGen()-1; $i++){
            $ret[] = rand(0,1);
        }
        return $ret;
    }
}

class Population
{
    function createRandomPopulation(){
        $individu = new Individu;
        for ($i = 0; $i <= Parameters::POPULATION_SIZE-1; $i++){
           $ret[] = $individu-> createRandomIndividu();
        } 
        return $ret;
    }
}

class Fitness
{
    function selectingItem($individu)
    {
        $catalogue = new Catalogue;
        foreach($individu as $individuKey => $binaryGen){
            if ($binaryGen == 1){
                $ret[] = [
                    'selectedKey' => $individuKey,
                    'selectedPrice' => $catalogue->product()[$individuKey]['price']
                ];
            }
        }
        return $ret;
    }

    function calculateFitnessValue($individu)
    {
       return array_sum(array_column($this->selectingItem($individu),'selectedPrice'));
    }

    function countSelectedItem($individu)
    {
        return count($this->selectingItem($individu));
    }

    function searchBestIndividu($fits, $maxItem, $numberOfIndividuHasMaxItem)
    {
        if ($numberOfIndividuHasMaxItem === 1){
            $index = array_search($maxItem, array_column($fits, 'numberOfSelectedItem'));
            return $fits[$index];
        } else{
            foreach ($fits as $key => $val){
                if ($val['numberOfSelectedItem'] === $maxItem){
                    echo $key.' '.$val['fitnessValue'].'<br>';
                    $ret[] = [
                        'individuKey' => $key,
                        'fitnessValue' => $val['fitnessValue']
                    ];
                }
            }
            if(count(array_unique(array_column($ret, 'fitnessValue'))) === 1){
                $index = rand(0, count($ret) -1);
            }else{
                $max = max(array_column($ret, 'fitnessValue'));
                $index = array_search($max, array_column($ret,'fitnessValue'));
            }
            echo 'Hasil';
            return ($ret[$index]);
        }
    } 

    function isFound($fits)
    {
        $countedMaxItem = array_count_values(array_column($fits,'numberOfSelectedItem'));
        print_r($countedMaxItem);
        echo '<br>';
        $maxItem = max(array_keys($countedMaxItem));
        echo $maxItem;
        echo '<br>';
        echo $countedMaxItem[$maxItem];
        $numberOfIndividuHasMaxItem = $countedMaxItem[$maxItem];

        $bestFitnessValue = $this->searchBestIndividu($fits, $maxItem, $numberOfIndividuHasMaxItem)['fitnessValue'];
        echo '<br';
        echo '<br>Best fitness value: '.$bestFitnessValue;

        $residual = Parameters::BUDGET -$bestFitnessValue;
        echo ' Residual: '.$residual;

        if($residual<=Parameters::STOPPING_VALUE && $residual > 0){
            return TRUE;
        }
    }

    function isFit($fitnessValue)
    {
        if ($fitnessValue <= Parameters::BUDGET){
            return TRUE;
        }
    }

    function fitnessEvaluation($population)
    {
        $catalogue = new Catalogue;
        foreach ($population as $listOfIndividuKey => $listOfIndividu){
            echo 'Individu-'. $listOfIndividuKey.'<br>';
            foreach ($listOfIndividu as $individuKey => $binaryGen){
                echo $binaryGen.'&nbsp,&nbsp';
                print_r($catalogue->product()[$individuKey]);
                echo '<br>';
            }
            $fitnessValue = $this->calculateFitnessValue($listOfIndividu);
            $numberOfSelectedItem = $this->countSelectedItem($listOfIndividu);
            echo 'Max. Item: '. $numberOfSelectedItem;
            echo ' Fitnes value: '.$fitnessValue;
            if($this->isFit($fitnessValue)){
                echo '(Fit)';
                $fits[]= [
                    'selectedIndividuKey' => $listOfIndividuKey,
                    'numberOfSelectedItem' => $numberOfSelectedItem,
                    'fitnessValue' => $fitnessValue
            ];
            echo'<p>';
            print_r($fits);
            }else{
                echo'Not Fit';
            }
            echo '<p>';
        }

        if ($this->isfound($fits)){
            echo'Found';
        } else {
            echo '>> Next generation';
        }
    }
}

class Crossover
{
    public $populations;

    function __construct($populations)
    {
        $this->populations = $populations;
    }

    function RandoomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }

    function generateCrossover()
    {
        for ($i = 0; $i <= Parameters::POPULATION_SIZE-1; $i++){
            $randomZeroToOne = $this->randoomZeroToOne();
            if ($randomZeroToOne < Parameters::CROSOVER_RATE){
                $parents[$i] = $randomZeroToOne;
            }
        }
        foreach (array_keys($parents) as $key){
            foreach (array_keys($parents) as $subkey){
                if ($key !== $subkey){
                    $ret[] = [$key, $subkey];
                }
            }
            array_shift($parents);
        }
        return $ret;
    }

    function offsring($parent1, $parent2, $cutPointIndex, $offspring)
    {
        $lengtOfGen = new Individu;
        if ($offspring === 1) {
            for ($i = 0; $i <= $lengtOfGen->countNumberOfGen()-1; $i++){
                if ($i <= $cutPointIndex){
                    $ret[] = $parent1[$i];
                }
                if($i > $cutPointIndex){
                    $ret[] = $parent2[$i];
                }
            }
        
        }

        if ($offspring === 2) {
            for ($i = 0; $i <= $lengtOfGen->countNumberOfGen()-1; $i++){
                if ($i <= $cutPointIndex){
                    $ret[] = $parent2[$i];
                }
                if($i > $cutPointIndex){
                    $ret[] = $parent1[$i];
                }
            }
        
        }
        return $ret;

    }

    function cutPointRandom()
    {
        $lengtOfGen = new Individu;
        return rand(0, $lengtOfGen->countNumberOfGen() -1 );
    }
         
    function crossover()
    {
        $cutPointIndex = $this->cutPointRandom();
        echo $cutPointIndex;
        foreach ($this->generateCrossover() as $listOfCrossover){
           $parent1 = $this->populations[$listOfCrossover[0]];
           $parent2 = $this->populations[$listOfCrossover[1]];
           echo '<p></p>';
           echo 'Parents : <br>';
           foreach ($parent1 as $gen){
               echo $gen;
            }
            echo ' >< ';
            foreach($parent2 as $gen) {
                echo $gen; 
            }
            echo '<br>';

            echo 'Offspring<br>';
            $offspring1 = $this->offsring($parent1, $parent2, $cutPointIndex, 1);
            $offspring2 = $this->offsring($parent1, $parent2, $cutPointIndex, 2);
            foreach ( $offspring1 as $gen){
                echo $gen;
            }
             echo ' >< ';
             foreach($offspring2 as $gen) {
                 echo $gen; 
            }
            echo '<br>';
        }
    }
}


$initialPopulation = new Population;
$population = $initialPopulation->createRandomPopulation();

$fitness = new Fitness;
$fitness ->fitnessEvaluation($population);

$crossovver = new crossover($population);
$crossovver->crossover();
// $individu = new Individu;
// print_r($individu->createRandomIndividu());