<?php

class Catalogue
{
    function createProductColumn($columns, $ListOfRawProduct) {
        foreach (array_keys($ListOfRawProduct) as $ListOfRawProductKey) {
            $ListOfRawProduct[$columns[$ListOfRawProductKey]] = $ListOfRawProduct[$ListOfRawProductKey];
            unset($ListOfRawProduct[$ListOfRawProductKey]);
        }
        return $ListOfRawProduct;
    }

    function product($parameters) {
        $collectionOfListProduct = [];

        $raw_data = file($parameters['file_name']);
        foreach ($raw_data as $ListOfRawProduct) {
            $collectionOfListProduct[] = $this->createProductColumn($parameters['columns'], explode(",", $ListOfRawProduct));
        }

        return [
            'product' => $collectionOfListProduct,
            'gen_length' => count($collectionOfListProduct)
        ];
    }
}

$parameters = [
    'file_name' => 'products.txt',
    'columns' => ['item', 'price']
];

$katalog = new Catalogue;
print_r($katalog->product($parameters));

?>