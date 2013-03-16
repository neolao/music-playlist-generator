<?php
/**
 * @package Playlist\Util
 */
namespace Playlist\Util;

/**
 * Class utility for command line
 */
class Cli
{
    /**
     * Get colored string
     *
     * @param   string  $message            The string
     * @param   string  $foregroundColor    The foreground color
     * @param   string  $backgroundColor    The background color
     * @return  string                      The colored string
     */
    public static function getColoredString($message, $foregroundColor = null, $backgroundColor = null)
    {
        $foregroundColors = [
            'black'         => '0;30',
            'dark_gray'     => '1;30',
            'blue'          => '0;34',
            'light_blue'    => '1;34',
            'green'         => '0;32',
            'light_green'   => '1;32',
            'cyan'          => '0;36',
            'light_cyan'    => '1;36',
            'red'           => '0;31',
            'light_red'     => '1;31',
            'purple'        => '0;35',
            'light_purple'  => '1;35',
            'brown'         => '0;33',
            'yellow'        => '1;33',
            'light_gray'    => '0;37',
            'white'         => '1;37'
        ];
        $backgroundColors = [
            'black'         => '40',
            'red'           => '41',
            'green'         => '42',
            'yellow'        => '43',
            'blue'          => '44',
            'magenta'       => '45',
            'cyan'          => '46',
            'light_gray'    => '47'
        ];
        $result = '';

        if (isset($foregroundColors[$foregroundColor])) {
            $result .= "\033[".$foregroundColors[$foregroundColor].'m';
        }
        if (isset($backgroundColors[$backgroundColor])) {
            $result .= "\033[".$backgroundColors[$backgroundColor].'m';
        }

        $result .= $message."\033[0m";

        return $result;
    }

    /**
     * Prompt a question to the user
     *
     * @param   string  $question           The question
     * @param   string  $foregroundColor    The foreground color
     * @param   string  $backgroundColor    The background color
     * @return  string                      The answer
     */
    public static function prompt($question, $foregroundColor = null, $backgroundColor = null)
    {
        echo self::getColoredString($question, $foregroundColor, $backgroundColor);
        echo ' ';
        $answer = trim(fgets(STDIN));
        return $answer;
    }
}

