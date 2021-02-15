<?php


class View
{
    function generate($contentView, $templateView, $data = null, $title = 'EnglishGenius')
    {
        require ROOT . '/view/'.$templateView;
    }
}