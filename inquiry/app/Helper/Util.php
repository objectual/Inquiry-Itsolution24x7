<?php

namespace App\Helper;

/**
 * Class UtilHelper
 * @package App\Helper
 */
class Util
{
    const BOOL_FALSE = 0;
    const BOOL_TRUE = 1;

    /**
     * @var array
     */
    public static $BOOL = [
        self::BOOL_FALSE => "No",
        self::BOOL_TRUE  => "Yes",
    ];

    /**
     * @var array
     */
    public static $BOOL_CSS = [
        self::BOOL_FALSE => "danger",
        self::BOOL_TRUE  => "success",
    ];

    /**
     * @var array
     */
    public static $BOOL_BG_CSS = [
        self::BOOL_FALSE => "red",
        self::BOOL_TRUE  => "green",
    ];

    /**
     * @param $value
     * @return mixed
     */
    public static function getBoolText($value)
    {
        return self::$BOOL[$value];
    }

    /**
     * @param $value
     * @param bool $bg
     * @return mixed
     */
    public static function getBoolCss($value, $bg = false)
    {
        return $bg ? self::$BOOL_BG_CSS[$value] : self::$BOOL_CSS[$value];
    }

    /**
     * @param $file
     * @param int $colName
     * @return array
     */
    public function readCSV($file, $colName = 0)
    {
        $row = 0;
        $rows = $columns = [];
        $autoLineEndings = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', TRUE);

        if (($handle = fopen(public_path() . '/csv/' . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if (count($data) <= 1) {
                    $columns[] = $data;
                    continue;
                }
                $row++;
                if ($row == 1) {
                    $columns[] = $data;
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
        ini_set('auto_detect_line_endings', $autoLineEndings);

        if ($colName) {
            return [
                'columns' => $columns,
                'rows'    => $rows
            ];
        } else {
            return $rows;
        }
    }

    /**
     * @param $file
     * @param $data
     * @return bool
     */
    public function updateCSV($file, $data)
    {
        $current_content = $this->readCSV($file, 1);
        $new_data[0] = $data;
        $new_content = array_merge($current_content['columns'], $current_content['rows'], $data);

        $fp = fopen(public_path() . '/csv/' . $file, 'w');
        foreach ($new_content as $content) {
            fputcsv($fp, $content);
        }
        fclose($fp);

        return true;
    }

    /**
     * @param $file
     * @return array
     */
    public function seedWithCSV($file)
    {
        $newData = [];
        $data = $this->readCSV($file, 1);

        foreach ($data['rows'] as $key => $row) {
            foreach ($row as $keys => $item) {
                $newData[$key][$data['columns'][0][$keys]] = $item;
            }
        }
        return $newData;
    }
}