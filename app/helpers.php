<?php

if (!function_exists('word_count')) {
  function word_count($text): array|int
  {
    return str_word_count(strip_tags($text));
  }
}

if (!function_exists('reading_time')) {
  function reading_time($text, $wordsPerMinute = 200): string
  {
    $wordCount = word_count($text);
    $minutes = ceil($wordCount / $wordsPerMinute);

    return $minutes . ' min read';
  }
}