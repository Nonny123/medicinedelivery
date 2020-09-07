<?php

    class ItemList extends Eloquent
    {
        protected $table = 'cart';
        public $timestamps = false;

        public function medicine_details()
        {
            return $this->hasOne('Medicine', 'id', 'medicine')->select('item_code', 'item_name')->first();
        }
    }
