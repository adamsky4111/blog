<?php

namespace App\Repository\SearchRepository;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FOS\ElasticaBundle\Repository;

class SearchPostRepository extends Repository
{
    public function search($search = null, $limit = 10)
    {
        $query = new Query();

        $boolQuery = new BoolQuery();

        if (!\is_null($search)) {
            $fieldQuery = new Query\MatchPhrasePrefix();
            $fieldQuery->setField('title', $search);
            $boolQuery->addMust($fieldQuery);
        }

        $query->setQuery($boolQuery);
        $query->setSize($limit);

        return $this->find($query);
    }
}