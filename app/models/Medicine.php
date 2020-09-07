<?php

class Medicine extends Eloquent
{
    protected $table = 'medicine';
    public $timestamps = false;

    /**
     * Get all Medicines
     */
    public static function medicines($key = '')
    {
        $medicines = Cache::get(CACHE_PARAM_MEDICINE, null);
        if (is_null($medicines)) {
            $medicine_list = self::select('id', 'item_name', 'item_name as value', 'item_code', 'selling_price as mrp', 'composition', 'discount', 'discount_type', 'tax', 'tax_type', 'manufacturer', 'group', 'is_delete')->get()->toArray();
            $medicines = [];
            foreach ($medicine_list as $list) {
                $medicines[$list['id']] = $list;
            }
            Cache::put(CACHE_PARAM_MEDICINE, $medicines, 1440);
        }
        return empty($key) ? $medicines : $medicines[$key];
    }
}
