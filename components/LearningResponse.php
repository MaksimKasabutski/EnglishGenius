<?php

namespace Components;

use JsonSerializable;

class LearningResponse implements JsonSerializable
{
    protected $word;
    protected $translation;
    protected $pos;
    protected $status;

    public function __construct($word, $translation, $pos, $status = NULL)
    {
        $this->word = $word;
        $this->translation = $translation;
        $this->pos = $pos;
        $this->status = $status;
    }

    public function jsonSerialize(): array
    {
        return [
            'word' => $this->word,
            'translation' => $this->translation,
            'pos' => $this->pos,
            'status' => $this->status
        ];
    }
}