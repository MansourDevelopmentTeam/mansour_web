<?php

namespace App\Models\Products;

    trait SearchableTrait
{
    public $stopwords = ["a", "about", "an", "are", "as", "at", "be", "by", "com", "de", "en", "for", "from", "how", "i", "in", "is", "it", "la", "of", "on", "or", "that", "the", "this", "to", "was", "what", "when", "where", "who", "will", "with", "und", "the", "www"];

    protected function fullTextWildcards($term)
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, ' ', $term);

        $words = explode(' ', $term);
        $words = array_diff($words, $this->stopwords);

        foreach ($words as $key => $word) {
            $words[$key] = '+' . $word . '*';
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }


    public function scopeSearch($query, $term)
    {
        $columns = implode(',', $this->searchable);

        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));

        return $query;
    }

    public function scopeSearchWithRelevance($query, $term)
    {
        $columns = implode(',', $this->searchable);

        $searchableTerm = $this->fullTextWildcards($term);

        return $query->selectRaw("*, MATCH ({$columns}) AGAINST (? IN NATURAL LANGUAGE MODE) AS relevance_score", [$searchableTerm])
            ->whereRaw("MATCH ({$columns}) AGAINST (? IN NATURAL LANGUAGE MODE)", $searchableTerm)
            ->orderByDesc('relevance_score');
    }
}
