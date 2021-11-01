<?php

namespace App\Criteria;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria;
 */
class BaseCriteria
{
    const LIKE_BOTH = 0;
    const LIKE_BEFORE = 10;
    const LIKE_AFTER = 20;

    /**
     * BaseCriteria constructor.
     * @param array $settings
     */
    public function __construct($settings = [])
    {
        foreach ($settings as $key => $setting) {
            if (property_exists($this, $key) !== false) {
                $this->$key = $setting;
            }
        }
    }

    public function exists($prop)
    {
        return (property_exists($this, $prop) && !is_null($this->$prop));
    }

    public function getLikeQuery($value, $type=self::LIKE_BOTH)
    {
        switch($type){
            default:
            case self::LIKE_BOTH:
                return "%" . $value . "%";
                break;
            case self::LIKE_BEFORE:
                return "%" . $value;
                break;
            case self::LIKE_AFTER:
                return $value . "%";
                break;
        }
    }
}