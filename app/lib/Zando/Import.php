<?php

namespace Zando;

use \PDO;
use \Couchbase;

class Import
{

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var Couchbase
     */
    protected $cb;


    public function __construct()
    {
        $this->connectToDB('localhost', 'zando_bob', 'root', 'password');
        $this->connectToCouchbase('127.0.0.1:8091', 'default', 'default');
    }

    public function import() {
        $this->insertProductsIntoCouchbase($this->fetchProducts());
    }

    protected function connectToDB($host, $db, $username, $password)
    {
        $this->db = new \PDO(sprintf("mysql:host=%s;dbname=%s", $host, $db), $username, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function connectToCouchbase($host, $bucket, $documentType)
    {
        $this->cb = new Couchbase($host, $bucket, "", $documentType);
    }

    protected function fetchProducts($qty = 20000)
    {
        $query = "SELECT * FROM `keyvalue` WHERE `key` LIKE 'zandoproduct_%' LIMIT $qty";

        $statement = $this->db->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    protected function insertProductsIntoCouchbase($products)
    {
        foreach($products as $product) {
            $this->cb->add($product->key, json_encode($this->prepareProduct(json_decode($product->value))));
        }
    }

    protected function prepareProduct($product) {

        $tmpProduct = $product;

        if (isset($product->simples)) {
            $product->simples = array_values(get_object_vars($product->simples));
        }

        if (isset($product->meta->grouped_products)) {
            $product->meta->grouped_products = explode('|', $product->meta->grouped_products);
        }
        if (isset($product->meta->categories)) {
            $product->meta->categories = explode('|', $product->meta->categories);
        }

        if (isset($product->meta->occasion)) {
            $product->meta->occasion = explode('|', $product->meta->occasion);
        }

        if (isset($product->meta->trend)) {
            $product->meta->trend = explode('|', $product->meta->trend);
        }

        unset($product->grouped);
        unset($product->meta->buyer);
        unset($product->shipmentType);
        return $product;
    }

}