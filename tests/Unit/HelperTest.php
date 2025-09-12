<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelperTest extends TestCase
{
    public function test_word_count_function()
    {
        $text = "This is a test string.";
        $this->assertEquals(5, word_count($text));
    }

    public function test_word_count_function_with_tags()
    {
        $text = "<p>This is a <strong>test</strong> string with HTML tags.</p>";
        $this->assertEquals(8, word_count($text));
    }

    public function test_reading_time_function()
    {
        $text = str_repeat("This is a test string. ", 40); // 200 words
        $this->assertEquals("1 min read", reading_time($text));

        $text = str_repeat("This is a test string. ", 80); // 400 words
        $this->assertEquals("2 min read", reading_time($text));
    }
}
