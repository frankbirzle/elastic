<?php
/**
 * User: frank
 * Date: 15/02/14
 * Time: 11:16
 */

namespace Zando;

use Elastica;

class Search {

    protected $elasticaClient;
    protected $elasticaIndex;

    public function __construct(Elastica\Client $client, $searchIndex)
    {
        $this->elasticaClient = $client;
        $this->setSearchIndex($searchIndex);
    }

    protected function setSearchIndex($searchIndex)
    {
        $this->elasticaIndex = new Elastica\Index($this->elasticaClient, $searchIndex);
    }

    public function search($queryString)
    {
        $elasticaQueryString  = new Elastica\Query\QueryString();
        $elasticaQueryString->setDefaultOperator('AND');
        $elasticaQueryString->setQuery($queryString);

        // Create the actual search object with some data.
        $elasticaQuery        = new \Elastica\Query();
        $elasticaQuery->setQuery($elasticaQueryString);

        $elasticaFacet    = new \Elastica\Facet\Terms('myFacetName');
        $elasticaFacet->setField('doc.meta.color_family');
        $elasticaFacet->setSize(10);
        $elasticaFacet->setOrder('reverse_count');

        // Add that facet to the search query object.
        $elasticaQuery->addFacet($elasticaFacet);

        //Search on the index.
        $elasticaResultSet    = $this->elasticaIndex->search($elasticaQuery);
        return $elasticaResultSet->getFacets();
    }

}